import PathNames from "../const/pathNames";
import { getHtml, post } from "../services/request";

export default function (el) {
    if (el.newTagButton) el.newTagButton.onclick = function () {
        getHtml(PathNames.TAG_CREATE)
            .then(html => {
                const modal = document.createElement('div');
                modal.innerHTML = html;
                el.body.appendChild(modal);
                modal.querySelector('#submit-modal').onclick = function () {
                    let name = el.tagNameInput.value;
                    post(PathNames.TAG, {name: name})
                        .then(window.location.reload());
                }
            });
    }
}