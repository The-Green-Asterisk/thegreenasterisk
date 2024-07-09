import PathNames from "../const/pathNames";
import { getHtml, post } from "../services/request";
import initModal from "./modal.js";
import { buildModal } from "./modal.js";

export default function tags(el) {
    if (el.newTagButton) el.newTagButton.onclick = function () {
        getHtml(PathNames.TAG_CREATE)
            .then(html => {
                buildModal(el, html);
                initModal(el);
                el.modal.querySelector('#submit-modal').onclick = function () {
                    let name = el.modal.querySelector('#new-tag').value;
                    post(PathNames.TAG, {name: name})
                        .then(window.location.reload());
                }
            });
    }
}