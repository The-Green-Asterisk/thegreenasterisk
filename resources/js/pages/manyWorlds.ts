import ColorThief from 'colorthief';
import components from "../components";
import { buildModal } from "../components/modal";
import constants from "../const";
import El from "../const/elements";
import { del, getHtml } from "../services/request";

export default function manyWorlds(el: El) {
    components.navbar(el);
    components.modal(el);
    components.tabs(el);
    
    const colorThief = new ColorThief();

    const activeWorld = document.querySelector<HTMLDivElement>('#active-tab');
    if (activeWorld) {
        const bg = activeWorld.style.backgroundImage;
        const img = new Image();
        img.src = bg.slice(5, -2);
        img.onload = () => {
            const colors = colorThief.getPalette(img, 2);
            if (!colors) return;
            const color = colors[0];
            const secondaryColor = colors[1];
            if (el.root) {
                el.root.style.setProperty(`--world-color`, `rgb(${color[0]}, ${color[1]}, ${color[2]})`);
                el.root.style.setProperty(`--world-color-secondary`, `rgb(${secondaryColor[0]}, ${secondaryColor[1]}, ${secondaryColor[2]})`);
            }
        }
    } else {
        //
    }

    if (el.cancelCreateButton) {
        el.cancelCreateButton.onclick = function () {
            window.location.href = constants.PathNames.MANY_WORLDS;
        }
    }

    if (el.shortNameInput && el.worldNameInput) {
        el.worldNameInput.onkeyup = function () {
            if (el.shortNameInput && el.worldNameInput)
                el.shortNameInput.value = el.worldNameInput.value.replace(/\s+/g, '-').toLowerCase();
        }
    }

    // if (el.deleteButton) el.deleteButton.onclick = function () {
    //     getHtml(`${constants.PathNames.BLOG}/${el.deleteButton.value}/delete-confirm`)
    //         .then(html => {
    //             const modal = document.createElement('div');
    //             modal.innerHTML = html;
    //             el.body.appendChild(modal);
    //             components.modal(el);
    //             modal.querySelector<HTMLButtonElement>('#submit-modal').onclick = function () {
    //                 del(`${constants.PathNames.MANY_WORLDS}/${el.deleteButton.value}`)
    //                     .then(window.location.href = constants.PathNames.MANY_WORLDS);
    //             }
    //         });
    // }

    if (el.deleteCommentButtons) {
        function deleteConfirm(worldName: string, commentId: string, assetId: string | null = null, assetType: string | null = null) {
            function isAsset() {
                return assetId ? `/${assetType}/${assetId}` : '';
            }

            getHtml(`${constants.PathNames.MANY_WORLDS}/${worldName}${isAsset()}/comment/${commentId}/delete-confirm`)
                .then(html => {
                    const modal = buildModal(el, html);
                    components.modal(el);
                    let submit = modal.querySelector<HTMLButtonElement>('#submit-modal')
                    if (submit)
                        submit.onclick = function () {
                            del(`${constants.PathNames.MANY_WORLDS}/${worldName}${isAsset()}/comment/${commentId}`)
                                .then(res => {
                                    window.location.reload();
                                });
                        };
                });
        };
        el.deleteCommentButtons.forEach(button => {
            button.onclick = function (e) {
                e.preventDefault();
                el.assetType
                    ? deleteConfirm(el.worldId, button.value, button.name, el.assetType)
                    : deleteConfirm(button.name, button.value);
            }
        });
    }
}