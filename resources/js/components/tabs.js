export default function tabs(el) {
    if (el.tabs) {
        el.tabs.forEach(tab => {
            if (tab.bg) {
                tab.style.backgroundImage = tab.bg;
            }
        });
    }
}