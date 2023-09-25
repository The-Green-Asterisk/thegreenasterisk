import PathNames from "../const/pathNames";
import { get, getHtml } from "../services/request";
import initModal from "./modal";

export default function tabs(el) {
    if (el.tabs) {
        el.tabs.forEach(tab => {
            if (tab.bg) {
                tab.style.backgroundImage = tab.bg;
            }
        });
    }
}