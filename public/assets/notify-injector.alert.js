window.notify_success = function (msg) {
    alert(msg);
};
window.notify_error = function (message) {
    alert(message);
};
window.confirmation_dialog = function(message) {
    return new Promise((resolve, reject) => {
        const confirmation = confirm(message);

        if (confirmation) {
            resolve();
        }
        else {
            reject();
        }
    });
}