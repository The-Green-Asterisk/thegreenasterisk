import El from "../const/elements";

export default function tabs(el: El) {
    if (el.tabs) {
        el.tabs.forEach(tab => {
            if (tab.bg) {
                tab.style.backgroundImage = tab.bg;
            }
        });
    }
}