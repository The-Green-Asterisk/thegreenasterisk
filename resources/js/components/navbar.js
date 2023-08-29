import { get, getHtml } from "../services/request.js";

export default function (el) {
    window.logIn = function () {
        getHtml('/login')
            .then(html => {
                const modal = document.createElement('div');
                modal.innerHTML = html;
                el.body.appendChild(modal);
            }
            );
    }
    window.logOut = function () {
        get('/logout');
    }
}