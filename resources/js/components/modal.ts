import El from "../const/elements";

export default function modal(el: El) {
    el.grabModal();
    if (!el.modal) return;

    (el.modal.querySelectorAll('#close-modal') as NodeListOf<HTMLButtonElement>).forEach(button => {
        button.onclick = function () {
            el.modal.remove();
        }
    });
    el.modal.onclick = function (event) {
        if ((event.target as HTMLElement | null | undefined)?.id === el.modal.id) {
            el.modal.remove();
        }
    };
}

export function buildModal(el: El, html: string) {
    const modal = document.createElement('div');
    modal.innerHTML = html;
    el.body.appendChild(modal);
    return modal;
}