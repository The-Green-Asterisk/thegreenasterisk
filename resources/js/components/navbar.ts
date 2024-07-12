import constants from "../const";
import { getHtml } from "../services/request";
import initModal from "./modal.js";
import { buildModal } from "./modal.js";
import El from "../const/elements";

export default function navbar(el: El) {
    if (el.logInButton) {
        function doLogIn() {
            getHtml(constants.PathNames.LOGIN)
            .then(html => {
                buildModal(el, html);
                initModal(el);
            });
        }
        
        el.logInButton.forEach(button => {
            button.onclick = doLogIn;
        });
    }
}