const el = {
    body: document.querySelector('body'),
    loader: document.querySelector('#loader'),
    navbar: document.querySelector('navbar'),
    formInputs: document.querySelectorAll('input, textarea'),
    submitButton: document.querySelector('button[type="submit"]'),
    modal: document.querySelector('.modal') ? document.querySelector('.modal')[0] : null,
    cookieBanner: document.querySelector('#cookie-banner'),
    cookieBannerButton: document.querySelector('#cookie-banner-button'),
    selectors: document.querySelector('select'),
    options: document.getElementsByTagName('option'),
    inputs: document.getElementsByTagName('input'),
    tagNameInput: document.querySelector('#tag_name'),
    modal: document.querySelector('#modal'),
    blogPane: document.querySelector('#blog-pane'),
    imagePreview: document.querySelector('#image-preview'),
    crfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
}
export default el;