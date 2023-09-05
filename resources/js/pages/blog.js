import initModal from "../components/modal";
import PathNames from "../const/pathNames";
import { del, getHtml } from "../services/request";

export default function (el) {
    if (el.cancelCreateButton) el.cancelCreateButton.onclick = function () {
        window.location.href = PathNames.BLOG;
    }
    if (el.cancelEditButton) el.cancelEditButton.onclick = function () {
        if (history.back()) {
            history.back();
        } else {
            window.location.href = PathNames.BLOG;
        };
    }
    if (el.backToBlogButton) el.backToBlogButton.onclick = function () {
        window.location.href = PathNames.BLOG;
    }

    if (el.deleteButton) el.deleteButton.onclick = function () {
        getHtml(`/blog/${el.deleteButton.value}/delete-confirm`)
            .then(html => {
                const modal = document.createElement('div');
                modal.innerHTML = html;
                el.body.appendChild(modal);
                modal.querySelector('#submit-modal').onclick = function () {
                    del(`/blog/${el.deleteButton.value}`)
                        .then(window.location.href = PathNames.BLOG);
                }
                initModal(el);
            });
    }

    if (el.clearTagButton) el.clearTagButton.onclick = function () {
        window.location.href = PathNames.BLOG;
    }

    if (el.viewButtons.length > 0) {
        el.viewButtons.forEach(button => {
            button.onclick = function () {
                window.location.href = button.value !== ''
                    ? `${PathNames.BLOG}?${button.value}=1`
                    : PathNames.BLOG;
            }
        });
    }

    if (el.createPostButton) el.createPostButton.onclick = function () {
        window.location.href = PathNames.BLOG_CREATE;
    }
    
    if (el.deleteCommentButtons) el.deleteCommentButtons.forEach(button => {
        button.onclick = getHtml(`/blog/comment/${button.value}/delete-confirm`)
            .then(html => {
                const modal = document.createElement('div');
                modal.innerHTML = html;
                el.body.appendChild(modal);
                modal.querySelector('#submit-modal').onclick = function () {
                    del(`/blog/comment/${button.value}`)
                        .then(res => window.location.href = res.url);
                }
                initModal(el);
            });
    });

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
            window.location.href = `${PathNames.BLOG}/${el.editBlogPostButton.value}/edit`;
        }
    }
    if (el.createPostButton) el.createPostButton.onclick = function () {
        localStorage.clear();
    }

    window.onbeforeunload=((oldBeforeUnload) => {
        return () => {
            oldBeforeUnload && oldBeforeUnload();
            if (el.formInputs.length == 0) return;
            
            let values = {};
            el.formInputs.forEach(input => {
                if (input && input.name && !input.name.startsWith('_') && input.type !== 'file')
                    values[input.name] = input.value;
            });

            let content = tinymce.get('content')?.getContent() ?? '';

            localStorage.setItem('formValues', JSON.stringify(values));
            localStorage.setItem('content', content);
        }
    })(window.onbeforeunload);
    window.onload=((oldLoad) => {
        return () => {
            oldLoad && oldLoad();
            if (el.formInputs.length == 0) return;
            
            let values = JSON.parse(localStorage.getItem('formValues'));
            let content = localStorage.getItem('content');

            el.formInputs.forEach(input => {
                if (input && input.name && !input.name.startsWith('_') && values && values[input.name] && input.type !== 'file')
                    input.value = values[input.name];
            });

            if (content && content !== undefined && content !== '') tinymce.get('content')?.setContent(content);

            localStorage.clear();
        }
    })(window.onload);

    if (el.blogPane) {
        let page = 1;
        let loading = false;
        el.blogPane.onscroll = function () {
            if ((this.scrollTop + this.clientHeight >= this.scrollHeight - 100) && !loading) {
                loading = true;
                getHtml(PathNames.INFINITE_SCROLL, {page: page})
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