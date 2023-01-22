window.newTag = function () {
    fetch('/tag/create')
        .then(response => response.text())
        .then(html => {
            const modal = document.createElement('div');
            modal.innerHTML = html;
            document.body.appendChild(modal);
            window.submitModal = function () {
                let name = document.getElementById('tag_name').value;
                fetch('/tag', {
                    method: 'POST',
                    body: JSON.stringify({
                        name: name
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).then(window.location.reload());
            }
        }
        );
}
