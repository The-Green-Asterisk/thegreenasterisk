export default function (el) {
    window.closeModal = function () {
        const modal = document.getElementById('modal');
        modal.remove();
    }
    window.outsideClick = function (event) {
        if (event.target.id === 'modal') {
            window.closeModal();
        }
    }
}