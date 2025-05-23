const documentEvents = {};

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

document.addEventListener('DOMContentLoaded', function () {
    const dataTableElement = document.querySelector('[data-datatable]');
    if(!dataTableElement) console.warn('Data table element not found');

    const apiUrl = dataTableElement.getAttribute('data-datatable');
    console.log('apiUrl: ' + apiUrl);

    const rowTemplate = dataTableElement.querySelector('[data-row-template]');
    const rowContainer = rowTemplate.parentNode;
    rowTemplate.style.display = 'none';


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
    function refreshList() {
        const requestPath = apiUrl + '/list';

        const searchDto = {};

        fetch(requestPath, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(searchDto)
        })
        .then(response => response.json())
        .then(response => {
            console.log(response);

            rowContainer.querySelectorAll('[data-temp-row]').forEach(row => {
                // Delete temp rows
                row.remove();
            });

            for(const item of response.Items) {
                let generatedRow = rowTemplate.cloneNode(true);
                generatedRow.style.display = '';

                bindData(generatedRow, item);

                rowTemplate.after(generatedRow);
            }

            // Fire a custom event that table data is available

            const dataAvailableEvent =
                new CustomEvent('tableDataFetched', { detail: response });
            dataTableElement.dispatchEvent(dataAvailableEvent);
        });
    }

    refreshList();
});

/*document.addEventListener('submit', function (e) {
    const form = e.target;

    if (!form.matches('form[data-ajax-form]')) return;

    e.preventDefault();
    console.log('prevented');

    const action = form.getAttribute('action');
    const data = new FormData(form);
    const params = new URLSearchParams(data).toString();

    fetch(action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: params
    })
    .then(response => response.json()) 
    .then(response => {
        if (check_and_notify(response)) {
            const inputs = form.querySelectorAll(':is(input, select, textarea):not(.ignore-reset):not([type="button"]):not([type="submit"]):not([type="reset"]):not([type="hidden"])');
            inputs.forEach(input => {
                input.value = '';
            });
        }

        const ajaxSubmitEvent = new CustomEvent('ajaxSubmitCompleted', { detail: response });
        form.dispatchEvent(ajaxSubmitEvent);
    });

    return false;
});*/

addListener('form[data-ajax-form]', 'submit', function (e) {
    e.preventDefault();
    console.log('prevented');

    const shouldReset = !!form.getAttribute('data-ajax-reset');
    const action = form.getAttribute('action');
    const data = formToObject(form);

    fetch(action, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: data
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

        const ajaxSubmitEvent = new CustomEvent('ajaxSubmitCompleted', { detail: response });
        form.dispatchEvent(ajaxSubmitEvent);
    });

    return false;
});


// Templating and rendering
