import components from "../components";
import ColorThief from '/node_modules/colorthief/dist/color-thief.mjs';
import PathNames from "../const/pathNames";

export default function manyWorlds(el) {
    components.navbar(el);
    components.modal(el);
    components.tabs(el);
    const colorThief = new ColorThief();

    const activeWorld = document.querySelector('#active-tab');
    if (activeWorld) {
        const bg = activeWorld.style.backgroundImage;
        const img = new Image();
        img.src = bg.slice(5, -2);
        img.onload = () => {
            const colors = colorThief.getPalette(img, 2);
            const color = colors[0];
            const secondaryColor = colors[1];
            el.root.style.setProperty(`--world-color`, `rgb(${color[0]}, ${color[1]}, ${color[2]})`);
            el.root.style.setProperty(`--world-color-secondary`, `rgb(${secondaryColor[0]}, ${secondaryColor[1]}, ${secondaryColor[2]})`);
        }
    } else {
        //
    }

    if (el.cancelCreateButton) {
        el.cancelCreateButton.onclick = function () {
            window.location.href = PathNames.MANY_WORLDS;
        }
    }

    if (el.shortNameInput) {
        el.worldNameInput.onkeyup = function () {
            el.shortNameInput.value = el.worldNameInput.value.replace(/\s+/g, '-').toLowerCase();
        }
    }

    if (el.deleteButton) el.deleteButton.onclick = function () {
        getHtml(`${PathNames.BLOG}/${el.deleteButton.value}/delete-confirm`)
            .then(html => {
                const modal = document.createElement('div');
                modal.innerHTML = html;
                el.body.appendChild(modal);
                components.modal(el);
                console.log(modal);
                modal.querySelector('#submit-modal').onclick = function () {
                    del(`${PathNames.MANY_WORLDS}/${el.deleteButton.value}`)
                        .then(window.location.href = PathNames.MANY_WORLDS);
                }
            });
    }
}