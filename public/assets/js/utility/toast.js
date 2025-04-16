document.addEventListener('DOMContentLoaded', function () {
    const toastElements = document.querySelectorAll('.toast');
    toastElements.forEach(function (el) {
        new bootstrap.Toast(el, {
            delay: 4000,
            autohide: true
        }).show();
    });
});