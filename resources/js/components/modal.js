export default function (el) {
    el.modal = el.grabModal();

    window.closeModal = function () {
        el.modal.remove();
    }
    window.outsideClick = function (event) {
        if (event.target.id === el.modal.id) {
            window.closeModal();
        }
    }
}