import { getHtml, post } from "../services/request";

export default function (el) {
    if (el.newTagButton) el.newTagButton.onclick = function () {
        getHtml('/tag/create')
            .then(html => {
                const modal = document.createElement('div');
                modal.innerHTML = html;
                el.body.appendChild(modal);
                modal.querySelector('#submit-modal').onclick = function () {
                    let name = el.tagNameInput.value;
                    post('/tag', {name: name})
                        .then(window.location.reload());
                }
            });
    }
}