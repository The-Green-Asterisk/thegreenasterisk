import CookieJar from "../services/cookieJar";
import StorageBox from "../services/storageBox";

export default class El {
    root = document.querySelector(':root');
    crfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    cookieBanner = document.querySelector('#cookie-banner');
    cookieBannerButton = document.querySelector('#cookie-banner-button');

    body = document.querySelector('body');
    loader = document.querySelector('#loader');
    navbar = document.querySelector('navbar');
    logInButton = document.querySelectorAll('#log-in-button');
    logOutButton = document.querySelector('#log-out-button');

    forms = document.querySelectorAll('form');
    inputs = document.getElementsByTagName('input');
    formInputs = document.querySelectorAll('input, textarea');
    submitButton = document.querySelector('button[type="submit"]');

    selectors = document.querySelectorAll('select');
    tagNameInput = document.querySelector('#tag-name');

    modal = document.querySelector('#modal');
    grabModal = () => this.modal = document.querySelector('#modal');

    blogPane = document.querySelector('#blog-pane');
    imagePreview = document.querySelector('#image-preview');
    image = document.querySelector('#image');
    cancelCreateButton = document.querySelector('#cancel-create-button');
    cancelEditButton = document.querySelector('#cancel-edit-button');
    deleteButton = document.querySelector('#delete-button');
    viewButtons = document.querySelectorAll('.view-button');
    createPostButton = document.querySelector('#create-post-button');
    editBlogPostButton = document.querySelector('#edit-blog-post-button');
    deleteCommentButtons = document.querySelectorAll('.delete-comment-button');
    backToBlogButton = document.querySelector('#back-to-blog-button');

    newTagButton = document.querySelector('#new-tag-button');
    clearTagButton = document.querySelector('#clear-tag-button');

    tabs = document.querySelectorAll('.tab');

    addNewElement = (element, elName) => {
        this[elName] = element;
        console.info(`${elName} has been added to elements temporarily. Be sure to add it to the class before pushing to production!`);
    };

    constructor() {
        if (this.selectors && this.selectors.length > 0) {
            this.selectors.forEach(selector => {
                selector.onclick = (e) => {
                    e.preventDefault();
                    selector.focus();
                };
                [...selector.options].forEach(option => {
                    option.onmousedown = (e) => {
                        e.preventDefault();
                        if (option.value === e.target.value) {
                            option.selected = !option.selected;
                        }
                    };
                });
            });
        }

        if (this.formInputs && this.submitButton) {
            this.formInputs.forEach(input => {
                if (input.required) {
                    input.oninput = () => {
                        if ([...this.formInputs].every(input => input.value.length > 0)) {
                            this.submitButton.disabled = false;
                        } else {
                            this.submitButton.disabled = true;
                        }
                    };
                }
            });

            this.forms.forEach(form => {
                form.onsubmit = ((oldOnSubmit) => {
                    form.submitButton = form.querySelector('button[type="submit"]');
                    return (e) =>{
                        oldOnSubmit && oldOnSubmit(e);
                        form.submitButton.disabled = true;
                        form.submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                        this.submitted = true;
                    }
                })(form.onsubmit)
            });
        }

        window.onbeforeunload=((oldBeforeUnload) => {
            return () => {
                oldBeforeUnload && oldBeforeUnload();
                if (this.formInputs.length == 0) return;
                if (this.submitted) {
                    StorageBox.clear();
                    return;
                }
                
                let values = {};
                this.formInputs.forEach(input => {
                    if (input && input.name && !input.name.startsWith('_') && input.type !== 'file')
                        values[input.name] = input.value;
                });
    
                let content = tinymce.get('content')?.getContent() ?? '';
                let message = tinymce.get('message')?.getContent() ?? '';
    
                StorageBox.set('formValues', values);
                StorageBox.set('content', content);
                StorageBox.set('message', message);
            }
        })(window.onbeforeunload);
        window.onload=((oldLoad) => {
            return () => {
                oldLoad && oldLoad();
                if (this.formInputs.length == 0) return;
                
                let values = StorageBox.get('formValues');
                let content = StorageBox.get('content');
                let message = StorageBox.get('message');
    
                this.formInputs.forEach(input => {
                    if (input && input.name && !input.name.startsWith('_') && values && values[input.name] && input.type !== 'file')
                        input.value = values[input.name];
                });
    
                if (content && content !== undefined && content !== '') tinymce.get('content')?.setContent(content);
                if (message && message !== undefined && message !== '') tinymce.get('message')?.setContent(message);
    
                localStorage.clear();
            }
        })(window.onload);

        if (CookieJar.get('cookies-are-cool')) {
            this.cookieBanner.style.display = 'none';
        } else {
            this.cookieBanner.style.display = 'flex';
        };

        if (this.cookieBannerButton) {
            this.cookieBannerButton.onclick = () => {
                this.cookieBanner.style.display = 'none';
                CookieJar.set('cookies-are-cool', true, new Date(Date.getFullYear() + 999).toUTCString());
            };
        }

        if (document.querySelectorAll('div, body')) {
            document.querySelectorAll('div, body').forEach(div => {
                if (div.getAttribute('bg'))
                    div.style.backgroundImage = `url(${div.getAttribute('bg')})`;
            })
        }
    }
};