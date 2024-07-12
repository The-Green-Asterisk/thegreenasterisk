import El from "../const/elements";
import PathNames from "../const/pathNames";
import { getHtml, post } from "../services/request";
import initModal, { buildModal } from "./modal.js";

export default function tags(el: El) {
    if (el.newTagButton) el.newTagButton.onclick = function () {
        getHtml(PathNames.TAG_CREATE)
            .then(html => {
                buildModal(el, html);
                initModal(el);
                (el.modal?.querySelector('#submit-modal') as HTMLButtonElement).onclick = function () {
                    let name = (el.modal?.querySelector('#new-tag') as HTMLInputElement).value;
                    post(PathNames.TAG, {name: name})
                        .then(() => window.location.reload());
                }
            });
    }
}