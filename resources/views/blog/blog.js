window.deleteModal = function (id) {
    fetch(`/blog/${id}/delete-confirm`)
        .then(response => response.text())
        .then(html => {
            const modal = document.createElement('div');
            modal.innerHTML = html;
            document.body.appendChild(modal);
            window.submitModal = function () {
                fetch(`/blog/${id}`, {
                    method: 'POST',
                    body: JSON.stringify({
                        _method: 'DELETE'
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).then(window.location.href = '/blog');
            }
        }
        );
}
window.deleteCommentModal = function (id) {
    fetch(`/blog/comment/${id}/delete-confirm`)
        .then(response => response.text())
        .then(html => {
            const modal = document.createElement('div');
            modal.innerHTML = html;
            document.body.appendChild(modal);
            window.submitModal = function () {
                fetch(`/blog/comment/${id}`, {
                    method: 'POST',
                    body: JSON.stringify({
                        _method: 'DELETE'
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).then(res => window.location.href = res.url);
            }
        }
        );
}
window.cancelEdit = function () {
    if (history.back()) {
        history.back();
    } else {
        window.location.href = '/blog'
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
    document.querySelectorAll('input').forEach(input => {
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

    document.querySelectorAll('input').forEach(input => {
        if (input && input.name && !input.name.startsWith('_') && values && values[input.name] && input.type !== 'file')
            input.value = values[input.name];
    });

    if (content && content !== undefined && content !== '') tinymce.get('content')?.setContent(content);

    localStorage.clear();
}, 1000);
