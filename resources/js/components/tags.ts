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
                if (el.modal) {
                    let submit = el.modal.querySelector<HTMLButtonElement>('#submit-modal');
                    if (submit)
                        submit.onclick = function () {
                        if (el.modal) {
                            let name = el.modal.querySelector<HTMLInputElement>('#new-tag');
                            if (name)
                                post(PathNames.TAG, {name: name.value})
                                    .then(() => window.location.reload());
                        }
                    }
                }
            });
    }
}