import components from "../components";
import constants from "../const";
import { del, getHtml } from "../services/request";

export default function blog(el) {
    components.navbar(el);
    components.modal(el);
    components.tags(el);

    if (el.cancelCreateButton) el.cancelCreateButton.onclick = function () {
        window.location.href = constants.PathNames.BLOG;
    }
    if (el.cancelEditButton) el.cancelEditButton.onclick = function () {
        if (history.back()) {
            history.back();
        } else {
            window.location.href = constants.PathNames.BLOG;
        };
    }
    if (el.backToBlogButton) el.backToBlogButton.onclick = function () {
        window.location.href = constants.PathNames.BLOG;
    }

    if (el.deleteButton) el.deleteButton.onclick = function () {
        getHtml(`${constants.PathNames.BLOG}/${el.deleteButton.value}/delete-confirm`)
            .then(html => {
                const modal = document.createElement('div');
                modal.innerHTML = html;
                el.body.appendChild(modal);
                modal.querySelector('#submit-modal').onclick = function () {
                    del(`${constants.PathNames.BLOG}/${el.deleteButton.value}`)
                        .then(window.location.href = constants.PathNames.BLOG);
                }
                components.modal(el);
            });
    }

    if (el.clearTagButton) el.clearTagButton.onclick = function () {
        window.location.href = constants.PathNames.BLOG;
    }

    if (el.viewButtons.length > 0) el.viewButtons.forEach(button => {
        button.onclick = function () {
            window.location.href = button.value !== ''
                ? `${constants.PathNames.BLOG}?${button.value}=1`
                : constants.PathNames.BLOG;
        }
    });

    if (el.createPostButton) el.createPostButton.onclick = function () {
        localStorage.clear();
        window.location.href = constants.PathNames.BLOG_CREATE;
    };
    
    if (el.deleteCommentButtons) {
        function deleteConfirm(id) {
            getHtml(`${constants.PathNames.BLOG}/comment/${id}/delete-confirm`)
                .then(html => {
                    const modal = document.createElement('div');
                    modal.innerHTML = html;
                    el.body.appendChild(modal);
                    components.modal(el);
                    modal.querySelector('#submit-modal').onclick = function () {
                        del(`${constants.PathNames.BLOG}/comment/${id}`)
                            .then(res => {
                                window.location.href = res.url
                            });
                    };
                });
        };
        el.deleteCommentButtons.forEach(button => {
            button.onclick = function (e) {
                e.preventDefault();
                deleteConfirm(button.name);
            }
        });
    }

    if (el.image) el.image.onchange = () => {
        if (el.image.files && el.image.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                el.imagePreview.setAttribute('src', e.target.result);
            }

            reader.readAsDataURL(el.image.files[0]);
        }
    }
    

    if (el.editBlogPostButton) el.editBlogPostButton.onclick = function () {
        localStorage.clear();
        if (el.editBlogPostButton.type === 'button') {
            window.location.href = `${constants.PathNames.BLOG}/${el.editBlogPostButton.value}/edit`;
        }
    }

    if (el.blogPane) {
        let page = 1;
        let loading = false;
        el.blogPane.onscroll = function () {
            if ((this.scrollTop + this.clientHeight >= this.scrollHeight - 100) && !loading) {
                loading = true;
                getHtml(constants.PathNames.INFINITE_SCROLL, {page: page})
                    .then(html => {
                        if (html === '') return;
                        this.innerHTML += html;
                        page++;
                        loading = false;
                    });
            }
        }
    }
}