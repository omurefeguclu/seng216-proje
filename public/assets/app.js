const documentEvents = {};
const oegStates = new WeakMap();

function listenToDocument(event) {
    

    document.addEventListener(event, function (e) {
        const eventMap = documentEvents[event];

        if (!documentEvents[event]) return;
        
        const eventTarget = e.target;

        for (let selector in eventMap)
        {
            if(eventTarget.matches(selector)) {
                const eventCallback = eventMap[selector];
                if (eventCallback) {
                    eventCallback(e);
                }

                break;
            }
        }
        
    });
}
function addListener(selector, eventName, callback) {

    if (!documentEvents[eventName]) {
        documentEvents[eventName] = {};
        listenToDocument(eventName);
    }

    if (!documentEvents[eventName][selector]) {
        documentEvents[eventName][selector] = callback;
    } else {
        console.warn(`Event ${eventName} already registered for selector ${selector}`);
    }
}

function getState(element) {
    if(!oegStates.has(element))
    {
        oegStates.set(element, {});
    }

    return oegStates.get(element);
}

function check_and_notify(e) {
    if (e.Errors) {
        if ((typeof e.Errors) == 'string') {
            //single error
            //display the message
            window.notify_error(e.Errors);
        } else {
            //array of errors
            //source: http://docs.kendoui.com/getting-started/using-kendo-with/aspnet-mvc/helpers/grid/faq#how-do-i-display-model-state-errors?
            var message = "The following errors have occurred:";
            //create a message containing all errors.
            for(let error of e.Errors) {
                message += "\n";
                message += error;
            }

            //display the message
            //alert(message);
            window.notify_error(message);
        }
        return false;
    } else if (e.Data) {
        if ((typeof e.Data) == 'string') {
            //single error
            //display the message
            window.notify_success(e.Data);
        }
        else {
            window.notify_success(null);
        }
        return true;
    }
    else {
        return false;
    }
}

function formToObject(formElement) {
    var formValue = {};

    const inputs = formElement.querySelectorAll('input, select, textarea');

    inputs.forEach((input) => {
        const name = input.name;
        if (!name) return;

        if (input.type === 'checkbox') {
            formValue[name] = input.checked;
        } else if (input.type === 'radio') {
            if (input.checked) {
                formValue[name] = input.value;
            }
        } else {
            formValue[name] = input.value;
        }
    });

    return formValueToObject(formValue);
}

function formValueToObject(data) {
    var initMatch = /^([a-z0-9]+?)\[/i;
    var first = /^\[[a-z0-9]+?\]/i;
    var isNumber = /^\d+$/;
    var bracers = /[\[\]]/g;
    var splitter = /\]\[|\[|\]/g;

    for (var key in data) {
        if (initMatch.test(key)) {
            data[key.replace(initMatch, '[$1][')] = data[key];
        }
        else {
            data[key.replace(/^(.+)$/, '[$1]')] = data[key];
        }
        delete data[key];
    }


    for (var key in data) {
        processExpression(data, key, data[key]);
        delete data[key];
    }

    function processExpression(dataNode, key, value) {
        var e = key.split(splitter);

        if (e) {
            var e2 = [];
            for (var i = 0; i < e.length; i++) {
                if (e[i] !== '') { e2.push(e[i]); }
            }
            e = e2;
            if (e.length > 1) {
                var x = e[0];
                var target = dataNode[x];
                if (!target) {
                    if (isNumber.test(e[1])) {
                        dataNode[x] = [];
                    }
                    else {
                        dataNode[x] = {}
                    }
                }
                processExpression(dataNode[x], key.replace(first, ''), value);
            }
            else if (e.length == 1) {
                dataNode[e[0]] = value;
            }
            else {
                alert('This should not happen...');
            }
        }
    }

    return data;
}



function bindForm(formElement, data) {
    const inputs = formElement.querySelectorAll('input, select, textarea');

    inputs.forEach((input) => {
        const name = input.name;
        if (!name) {
            console.log(input);
            return;
        }

        const value = fieldValueByString(data, name);

        if (input.type === 'checkbox') {
            input.checked = !!value;
        } else if (input.type === 'radio') {
            input.checked = value == input.value;
            input.dispatchEvent(new Event('change'));
        } else {
            input.value = value !== undefined ? value : '';
            input.dispatchEvent(new Event('change'));
        }
    });

    function fieldValueByString(obj, path) {
        path = path.replace(/\[(\w+)\]/g, '.$1').replace(/^\./, '');
        return path.split('.').reduce((o, k) => (o && o[k] !== undefined ? o[k] : undefined), obj);
    }
}

const BindingFunctions = {}
BindingFunctions.formatDate = function (date) {
    return (new Date(date)).toLocaleDateString();
}

function updatePaginatorState(tableElement, paginatorElement, pageIndex, pageSize, totalCount) {
    const tableId = tableElement.id;
    const pageTemplate = paginatorElement.querySelector('[data-page-template]:not([data-temp])');
    const activePageTemplate = paginatorElement.querySelector('[data-active-page-template]:not([data-temp])');
    const pageContainer = pageTemplate.parentElement;

    pageTemplate.style.display='none';
    activePageTemplate.style.display='none';

    // Delete temp pages
    pageContainer.querySelectorAll('[data-temp]').forEach((element) => {
        element.remove();
    });

    function bindPageData(paginatorElement, pageIndex) {
        const linkElement = paginatorElement.querySelector('a, button');
        const pageBindElement = paginatorElement.querySelector('[data-page]');

        if(linkElement) {
            linkElement.setAttribute('data-page-button', `${tableId}#${pageIndex}`);
        }
        if(pageBindElement) {
            pageBindElement.innerHTML = (pageIndex + 1) + '';
        }
    }

    // Get pageRangeToCover
    const range = 2;
    const pageCount = Math.ceil(totalCount / pageSize);
    const startPage = Math.max(pageIndex - range, 0);
    const endPage = Math.min(pageIndex + range, pageCount - 1);

    // Generate new pages
    for(let i = startPage; i <= endPage; i++){
        const template = i === pageIndex ? activePageTemplate: pageTemplate;

        const paginatorElement = template.cloneNode(true);
        paginatorElement.style.display = '';
        paginatorElement.setAttribute('data-temp', 'true');

        bindPageData(paginatorElement, i);

        pageTemplate.before(paginatorElement);
    }
}
function bindData(rowElement, data)
{
    const contentBindings = rowElement.querySelectorAll('[data-content-binding]');
    const attrBindings = rowElement.querySelectorAll('[data-attr-binding]');

    for(let contentBinding of contentBindings) {
        const bindingField = contentBinding.getAttribute('data-content-binding');
        let relatedData = data[bindingField];
        const bindingFunc = contentBinding.getAttribute('data-binding-func');
        if(bindingFunc) {
            relatedData = BindingFunctions[bindingFunc](relatedData);
        }

        contentBinding.innerHTML = relatedData;
    }

    for(let attrBinding of attrBindings) {
        const bindingField = attrBinding.getAttribute('data-attr-binding');
        const bindingAttrName = attrBinding.getAttribute('data-attr-binding-target');
        const relatedData = data[bindingField];

        attrBinding.setAttribute(bindingAttrName, relatedData);
    }
}
function refreshDataTable(dataTableElement, resetPaginator) {
    if(!dataTableElement) console.warn('Data table element not found');

    const apiUrl = dataTableElement.getAttribute('data-datatable');
    console.log('apiUrl: ' + apiUrl);

    const requestPath = apiUrl + '/list';
    let searchDto = getState(dataTableElement).search || {};
    let paging = getState(dataTableElement).paging;
    if (!paging || resetPaginator) {
        paging = getState(dataTableElement).paging = {
            PageIndex: 0,
            PageSize: 10
        };
    }

    for(let field in searchDto) {
        if(searchDto[field] === undefined || searchDto[field] === '') {
            delete searchDto[field];
        }
    }

    const requestBody = {
        ...searchDto,
        ...paging
    };

    fetch(requestPath, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(requestBody)
    })
        .then(response => response.json())
        .then(response => {
            const rowTemplate = dataTableElement.querySelector('[data-row-template]:not([data-temp-row])');
            const rowContainer = rowTemplate.parentElement;
            rowTemplate.style.display = 'none';

            rowContainer.querySelectorAll('[data-temp-row]').forEach(tempRow => {

                // Delete temp rows
                tempRow.remove();
            });

            for(const item of response.Items) {
                let generatedRow = rowTemplate.cloneNode(true);
                generatedRow.style.display = '';
                generatedRow.setAttribute('data-temp-row', 'true');

                bindData(generatedRow, item);

                rowContainer.insertBefore(generatedRow, rowTemplate);
            }

            // Fire a custom event that table data is available

            const dataAvailableEvent =
                new CustomEvent('tableDataFetched', { detail: {
                        pageIndex: paging.PageIndex,
                        pageSize: paging.PageSize,
                        totalCount: response.TotalCount,
                        data: response.Items
                    }, bubbles: true });

            dataTableElement.dispatchEvent(dataAvailableEvent);
        });
}

addListener('form[data-ajax-form]', 'submit', function (e) {
    e.preventDefault();
    const form = e.target;
    console.log('prevented');

    const shouldReset = form.hasAttribute('data-ajax-reset');
    const action = form.getAttribute('action');
    const data = formToObject(form);

    fetch(action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(response => {
        
        if (check_and_notify(response)) {
            if(shouldReset) {
                const inputs = form.querySelectorAll(':is(input, select, textarea):not(.ignore-reset):not([type="button"]):not([type="submit"]):not([type="reset"]):not([type="hidden"])');
                inputs.forEach(input => {
                    input.value = '';
                });
            }
            
        }

        const ajaxSubmitEvent = new CustomEvent('ajaxSubmitCompleted', {
            detail: response
        });
        form.dispatchEvent(ajaxSubmitEvent);
    });

    return false;
});

addListener('[data-page-button]', 'click', function(e) {
    e.preventDefault();
    const clickedElement = e.target;

    const pageButtonCommand = clickedElement.getAttribute('data-page-button');
    const pageButtonCommandArgs = pageButtonCommand.split('#');

    const paginatedTableId = pageButtonCommandArgs[0];
    const paginatedTable = document.getElementById(paginatedTableId);

    const newPageIndex = parseInt(pageButtonCommandArgs[1]);

    getState(paginatedTable).paging = {
        ...(getState(paginatedTable).paging || {}),
        PageIndex: newPageIndex
    };

    refreshDataTable(paginatedTable, false);
});

addListener('[data-datatable-filter-group] *', 'input', function(e) {
    console.log('caught');
    const inputElement = e.target;
    const filterGroup = inputElement.closest('[data-datatable-filter-group]');

    const datatableSelector = filterGroup.getAttribute('data-datatable-filter-group');
    const datatableElement = document.querySelector(datatableSelector);

    const search = formToObject(filterGroup);

    getState(datatableElement).search = search;
    refreshDataTable(datatableElement, true);
});

addListener('[data-datatable]', 'tableDataFetched', function (e) {
    const datatableElement = e.target;

    const paginatorSelector = datatableElement.getAttribute('data-paginator');
    if(!paginatorSelector) return;

    const paginatorElement = document.querySelector(paginatorSelector);
    if(!paginatorElement) {
        return;
    }

    updatePaginatorState(datatableElement, paginatorElement, e.detail.pageIndex, 10, e.detail.totalCount);
});

// Templating and rendering
