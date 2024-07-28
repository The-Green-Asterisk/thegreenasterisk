import El from "../const/elements";

export default function modal(el: El) {
    el.grabModal();
    if (!el.modal) return;

    el.modal.querySelectorAll<HTMLButtonElement>('#close-modal').forEach(button => {
        button.onclick = function () {
            if (el.modal)
                el.modal.remove();
        }
    });
    el.modal.onclick = function (event) {
        if (el.modal && (event.target as HTMLElement | null | undefined)?.id === el.modal.id) {
            el.modal.remove();
        }
    };
}

export function buildModal(el: El, html: string) {
    const modal = document.createElement('div');
    modal.innerHTML = html;
    if (el.body)
        el.body.appendChild(modal);
    return modal;
}