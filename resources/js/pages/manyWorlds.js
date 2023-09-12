import components from "../components";
import ColorThief from '/node_modules/colorthief/dist/color-thief.mjs';

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
}