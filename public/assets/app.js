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

function handleProvider(valueProvider, ...args)
{
    if((typeof valueProvider === 'function'))
    {
        return valueProvider(...args);
    }

    return valueProvider;
}

function getState(element) {
    if(!element) {
        console.warn('State key element is invalid: ', element);
        return {};
    }

    if(!oegStates.has(element))
    {
        oegStates.set(element, {});
    }

    return oegStates.get(element);
}

function getJson(action) {
    return fetch(action, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(check_errors);
}
function postJson(action, data)
{
    return fetch(action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(check_errors);
}
function check_errors(response) {
    if (response.Errors) {
        if ((typeof response.Errors) == 'string') {
            return Promise.reject(response.Errors);
        } else {
            var message = "The following errors have occurred:";
            for(let error of response.Errors) {
                message += "\n";
                message += error;
            }

            return Promise.reject(message);
        }
    }

    return response;
}
function createFormAlertAdapter(form) {
    const errorElement = form.querySelector('[data-error]');
    if(!errorElement) {
        return {errorHandler: err=>{},successHandler: () => {}};
    }

    return {
        errorHandler: function(error) {
            const errorMsgSelector = errorElement.getAttribute('data-error');
            const errorMsgElement = errorElement.querySelector(errorMsgSelector);

            errorMsgElement.innerHTML = error;

            errorElement.classList.remove('d-none');
        },
        successHandler: function () {
            errorElement.classList.add('d-none');
        }
    };
}
function adaptFormAlert(form, request){
    const adapter = createFormAlertAdapter(form);

    request
        .then(adapter.successHandler)
        .catch(adapter.errorHandler);
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


function validateForm(form, ignoreDirtyCheck = false) {
    const inputFields = form.querySelectorAll('[data-validate]');

    let invalid = false;
    for(const inputField of inputFields) {
        console.log(inputField);
        if(!validateInputField(inputField, ignoreDirtyCheck)) {
            invalid = true;
        }
    }

    if (invalid) {
        toggleFormValid(form, false);
    }

    return !invalid;
}
function validateInputField(inputField, ignoreDirtyCheck = false) {
    const validateAttr = inputField.getAttribute('data-validate');

    let errorMessage = '';

    function isRequired(errMsg = '') {
        errorMessage = errMsg || 'Field is required';

        return !!inputField.value;
    }
    function isMatching(targetSelector, errMsg = '') {
        const targetElement = document.querySelector(targetSelector);

        errorMessage = errMsg || (`Fields are not matching: ${inputField.name} & ${targetElement.name}`);

        return inputField.value === targetElement.value;
    }

    const isValid = eval(validateAttr);
    const isDirty = getState(inputField).dirty;
    // Don't show the error visuals if input field is not dirty
    if(!ignoreDirtyCheck && !isDirty) {
        clearInputError(inputField);
    }
    else if(!isValid) {
        showInputError(inputField, errorMessage);
    }
    else {
        hideInputError(inputField);
    }

    return isValid;
}
function showInputError(inputField, errorMessage){
    inputField.classList.add("is-invalid");
    inputField.classList.remove("is-valid");

    const errorMsgSelector = inputField.getAttribute('data-error-msg');
    if(!errorMsgSelector) return;

    const errorMsgElement = document.querySelector(errorMsgSelector);
    if(!errorMsgElement) return;

    errorMsgElement.classList.remove('d-none');
    errorMsgElement.innerHTML = errorMessage;
}
function hideInputError(inputField) {
    inputField.classList.remove("is-invalid");
    inputField.classList.add("is-valid");

    const errorMsgSelector = inputField.getAttribute('data-error-msg');
    if(!errorMsgSelector) return;

    const errorMsgElement = document.querySelector(errorMsgSelector);
    if(!errorMsgElement) return;

    errorMsgElement.classList.add('d-none');
    errorMsgElement.innerHTML = '';
}
function clearInputError(inputField) {
    inputField.classList.remove("is-invalid");
    inputField.classList.remove("is-valid");

    const errorMsgSelector = inputField.getAttribute('data-error-msg');
    if(!errorMsgSelector) return;

    const errorMsgElement = document.querySelector(errorMsgSelector);
    if(!errorMsgElement) return;

    errorMsgElement.classList.add('d-none');
    errorMsgElement.innerHTML = '';
}

function toggleFormValid(form, isValid) {
    form.querySelectorAll('button[type="submit"]').forEach((submitButton) => {
       submitButton.disabled = !isValid;
    });
}


const BindingFunctions = {}
BindingFunctions.formatDate = function (date) {
    return (new Date(date)).toLocaleDateString();
};

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
function bindData(rowElement, data){
    const contentBindings = rowElement.querySelectorAll('[data-content-binding]');
    const attrBindings = rowElement.querySelectorAll('[data-attr-binding]');

    for(let contentBinding of contentBindings) {
        const bindingField = contentBinding.getAttribute('data-content-binding');
        let relatedData = data[bindingField];
        const bindingFunc = contentBinding.getAttribute('data-binding-func');
        if(bindingFunc) {
            Promise.resolve(BindingFunctions[bindingFunc](relatedData))
                .then(x => {
                    relatedData = x;

                    contentBinding.innerHTML = x;
                });
        }
        else {
            contentBinding.innerHTML = relatedData;
        }


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

    const dataSource = getState(dataTableElement).datasource;
    if(!dataSource) console.warn('Data source is not configured');


    const requestPath = dataSource.list;
    let searchDto = getState(dataTableElement).search || {};
    let paging = getState(dataTableElement).paging;
    if (!paging || resetPaginator) {
        paging = getState(dataTableElement).paging = {
            PageIndex: 0,
            PageSize: 5
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

    postJson(requestPath, requestBody)
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

addListener('[data-validate]', 'input', function (e) {
    const inputField = e.target;

   const form = e.target.closest('form');
   getState(inputField).dirty = true;


   // Validate form fields
    toggleFormValid(form, validateForm(form));
});

function submitForm(form, action, shouldReset = false){
    if(!validateForm(form, true)){
        console.log("form is invalid");
        return Promise.reject("invalid form");
    }

    const data = formToObject(form);

    const request = postJson(action, data)
        .then(response => {
            if(shouldReset) {
                const inputs = form.querySelectorAll(':is(input, select, textarea):not(.ignore-reset):not([type="button"]):not([type="submit"]):not([type="reset"]):not([type="hidden"])');
                inputs.forEach(input => {
                    input.value = '';
                });
            }

            const ajaxSubmitEvent = new CustomEvent('ajaxSubmitCompleted', {
                detail: response
            });
            form.dispatchEvent(ajaxSubmitEvent);
        });

    adaptFormAlert(form, request);

    return request;
}

addListener('form[data-ajax-form]', 'submit', function (e) {
    e.preventDefault();
    const form = e.target;
    const action = form.getAttribute('action');

    submitForm(form, action, true)

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

function initDatatable(selector, prefix) {
    const datatableElement = document.querySelector(selector);
    const paginatorSelector = datatableElement.getAttribute('data-paginator');

    const paginatorElement = paginatorSelector ? document.querySelector(paginatorSelector) : null;

    getState(datatableElement).datasource = {
        list: prefix + '/list',
        create: prefix + '/form',
        edit: prefix + '/form/:id',
        delete: prefix + '/delete/:id',
    };

    datatableElement.setAttribute('data-datatable', true);

    datatableElement.addEventListener('tableDataFetched', function (e) {
        if(!paginatorElement) return;

        updatePaginatorState(datatableElement, paginatorElement, e.detail.pageIndex, e.detail.pageSize, e.detail.totalCount);
    });

    refreshDataTable(datatableElement, true);

    return datatableElement;
}
function initFormModal(modalSelector, datatable, configuration = {}, initAction = () => {}) {
    const modalElement = document.querySelector(modalSelector);
    const datatableState = getState(datatable);

    getState(modalElement).config = {
        createUrl: datatableState.datasource.create,
        editUrl: datatableState.datasource.edit,
        datatable: datatable,
        createTitle: 'Create Item',
        editTitle: 'Edit Item',
        ...configuration
    };

    modalElement.querySelectorAll('button[type="submit"], input[type="submit"]').forEach(submitButton => {
        submitButton.addEventListener('click', e => {
            e.preventDefault();

            const modalForm = modalElement.querySelector('form');
            const modalState = getState(modalElement);

            const entityId = modalState.entityId;
            const requestUrl = entityId ? modalState.config.editUrl.replace(':id', entityId) : modalState.config.createUrl;

            submitForm(modalForm, requestUrl, false)
                .then(response => {

                    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

                    modal.hide();
                    console.log("successfully saved element");

                    refreshDataTable(modalState.config.datatable, false);
                });
        });

    });
}
function showFormModal(modalSelector, entityId) {
    const modalElement = document.querySelector(modalSelector);
    const modalState = getState(modalElement);


    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
    const modalTitle = modalElement.querySelector('.modal-title');


    const form = modalElement.querySelector('form');
    // Edit Form
    if(entityId) {
        getState(modalElement).entityId = entityId;
        const requestUrl = modalState.config.editUrl.replace(':id', entityId);

        getJson(requestUrl)
            .then(response => {
                modalTitle.innerHTML = handleProvider(modalState.config.editTitle, response);

                bindForm(form, response);

                modal.show();
            });


    }
    // Create Form
    else {
        getState(modalElement).entityId = undefined;
        modalTitle.innerHTML = modalState.config.createTitle;

        bindForm(form, {});

        modal.show();
    }

}

addListener('[data-form-modal-button]', 'click', function(e) {
   e.preventDefault();
   console.log('caught');

   const modalSelector = e.target.getAttribute('data-form-modal-button');
   const entityId = e.target.getAttribute('data-entity-id');

   showFormModal(modalSelector, entityId);
});

addListener('[data-delete-button]', 'click', function (e) {
    e.preventDefault();

    window.confirmation_dialog('Do you really want to delete item?')
        .then(() => {
            const entityId = e.target.getAttribute('data-entity-id');
            const datatable = e.target.closest('[data-datatable]');
            const datatableState = getState(datatable);

            const deleteUrl = datatableState.datasource.delete.replace(':id', entityId);

            getJson(deleteUrl)
                .then(() => {
                    refreshDataTable(datatable, false);
                })
                .catch(error => {

                });
        })


});

dropdownDatasourceCache = {};
function populateSelectList(selectListElement) {
    const datasource = selectListElement.getAttribute('data-datasource');

    // Remove all old values
    selectListElement.querySelectorAll('option:not([value=""])').forEach(opt => opt.remove());

    const optionTemplate = selectListElement.querySelector('option') || document.createElement('option');
    function bindOption(optionElement, itemText, itemValue) {
        optionElement.innerHTML = itemText;
        optionElement.setAttribute('value', itemValue);
    }



    (dropdownDatasourceCache[datasource] ||= getJson(datasource))
        .then(response => {
            for (const itemValue in response) {
                const itemText = response[itemValue];

                const optionElement = optionTemplate.cloneNode(true);

                bindOption(optionElement, itemText, itemValue);

                optionTemplate.after(optionElement);
            }
        });
}
function fromDataSource(dataSource, value) {
    return (dropdownDatasourceCache[dataSource] ||= getJson(dataSource))
        .then(response => {
            return response[value];
        });
}

document.querySelectorAll('select[data-datasource]').forEach(populateSelectList);

// Templating and rendering
