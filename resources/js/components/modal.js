export default function (el) {
    el.grabModal();
    if (!el.modal) return;

    el.modal.querySelectorAll('#close-modal').forEach(button => {
        button.onclick = function () {
            el.modal.remove();
        }
    });
    el.modal.onclick = function (event) {
        if (event.target.id === el.modal.id) {
            el.modal.remove();
        }
    };
}