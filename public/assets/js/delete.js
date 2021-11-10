//iife -> expresión de función inmediatamente invocada
(function () {
    let modalDelete = document.getElementById('modalDelete');
    modalDelete.addEventListener('show.bs.modal', function (event) {
        let element = event.relatedTarget;
        let action = element.getAttribute('data-url');
        let form = document.getElementById('modalDeleteResourceForm');
        form.action = action;
    });
})();

