import { getHtml, post } from "../services/request";

export default function (el) {
    window.newTag = function () {
        getHtml('/tag/create')
            .then(html => {
                const modal = document.createElement('div');
                modal.innerHTML = html;
                el.body.appendChild(modal);
                window.submitModal = function () {
                    let name = el.tagNameInput.value;
                    post('/tag', {name: name})
                        .then(window.location.reload());
                }
            });
    }
}