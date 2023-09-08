import PathNames from "../const/pathNames.js";
import { get, getHtml } from "../services/request.js";
import initModal from "./modal.js";

export default function navbar(el) {
    if (el.logInButton) {
        function doLogIn() {
            getHtml(PathNames.LOGIN)
            .then(html => {
                const modal = document.createElement('div');
                modal.innerHTML = html;
                el.body.appendChild(modal);
                initModal(el);
            });
        }
        
        if (NodeList.prototype.isPrototypeOf(el.logInButton) && el.logInButton.length > 0) {
            el.logInButton.forEach(button => {
                button.onclick = doLogIn;
            });
        } else {
            el.logInButton.onclick = doLogIn;
        }
    }
}