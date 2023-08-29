export default function (el) {
    window.closeModal = function () {
        el.modal.remove();
    }
    window.outsideClick = function (event) {
        if (event.target.id === 'modal') {
            window.closeModal();
        }
    }
}