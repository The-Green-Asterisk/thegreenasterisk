import pathNames from "../const/pathnames";
import { post, get, getHtml, del } from "../services/request";

export default function (el) {
    window.deleteModal = function (id) {
        getHtml(`/blog/${id}/delete-confirm`)
            .then(html => {
                const modal = document.createElement('div');
                modal.innerHTML = html;
                el.body.appendChild(modal);
                window.submitModal = function () {
                    del(`/blog/${id}`)
                        .then(window.location.href = pathNames.BLOG);
                }
            });
    }
    window.deleteCommentModal = function (id) {
        getHtml(`/blog/comment/${id}/delete-confirm`)
            .then(html => {
                const modal = document.createElement('div');
                modal.innerHTML = html;
                el.body.appendChild(modal);
                window.submitModal = function () {
                    del(`/blog/comment/${id}`)
                        .then(res => window.location.href = res.url);
                }
            }
            );
    }
    window.cancelEdit = function () {
        if (history.back()) {
            history.back();
        } else {
            window.location.href = pathNames.BLOG;
        };
    }
    window.imagePreview = function (input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('image-preview').setAttribute('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    window.onbeforeunload = function () {
        let values = {};
        el.inputs.forEach(input => {
            if (input && input.name && !input.name.startsWith('_') && input.type !== 'file')
                values[input.name] = input.value;
        });

        let content = tinymce.get('content')?.getContent() ?? '';

        localStorage.setItem('formValues', JSON.stringify(values));
        localStorage.setItem('content', content);
    };
    setTimeout(() => {
        let values = JSON.parse(localStorage.getItem('formValues'));
        let content = localStorage.getItem('content');

        el.inputs.forEach(input => {
            if (input && input.name && !input.name.startsWith('_') && values && values[input.name] && input.type !== 'file')
                input.value = values[input.name];
        });

        if (content && content !== undefined && content !== '') tinymce.get('content')?.setContent(content);

        localStorage.clear();
    }, 1000);

    if (document.querySelector('section#blog-pane')) {
        let page = 1;
        let loading = false;
        document.querySelector('section#blog-pane').onscroll = function () {
            if ((this.scrollTop + this.clientHeight >= this.scrollHeight - 100) && !loading) {
                loading = true;
                getHtml('/infinite-scroll?page=' + page)
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