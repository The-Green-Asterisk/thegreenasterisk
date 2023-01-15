window.logIn = function () {
    fetch('/login')
        .then(response => response.text())
        .then(html => {
            const modal = document.createElement('div');
            modal.innerHTML = html;
            document.body.appendChild(modal);
        }
        );
}
window.logOut = function () {
    fetch('/logout');
}
