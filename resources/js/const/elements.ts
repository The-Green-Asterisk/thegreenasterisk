import CookieJar from "../services/cookieJar";
import StorageBox from "../services/storageBox";

export default class El {
    root = document.querySelector(':root') as HTMLElement;
    crfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

    cookieBanner = document.querySelector('#cookie-banner') as HTMLElement;
    cookieBannerButton = document.querySelector('#cookie-banner-button') as HTMLElement;

    body = document.querySelector('body') as HTMLBodyElement;
    loader = document.querySelector('#loader') as HTMLElement;
    navbar = document.querySelector('navbar') as HTMLElement;
    logInButton = document.querySelectorAll('#log-in-button') as NodeListOf<HTMLAnchorElement>;
    logOutButton = document.querySelector('#log-out-button') as HTMLElement;

    forms = document.querySelectorAll('form') as NodeListOf<HTMLFormElement>;
    inputs = document.getElementsByTagName('input') as HTMLCollectionOf<HTMLInputElement>;
    formInputs = document.querySelectorAll('input, textarea') as NodeListOf<HTMLInputElement | HTMLTextAreaElement>;
    submitButton = document.querySelector('button[type="submit"]') as HTMLButtonElement;

    selectors = document.querySelectorAll('select') as NodeListOf<HTMLSelectElement>;

    modal = document.querySelector('#modal') as HTMLElement;
    grabModal = () => this.modal = document.querySelector('#modal') as HTMLElement;

    blogPane = document.querySelector('#blog-pane') as HTMLDivElement;
    imagePreview = document.querySelector('#image-preview') as HTMLImageElement;
    image = document.querySelector('#image') as HTMLInputElement;
    cancelCreateButton = document.querySelector('#cancel-create-button') as HTMLButtonElement;
    cancelEditButton = document.querySelector('#cancel-edit-button') as HTMLButtonElement;
    deleteButton = document.querySelector('#delete-button') as HTMLButtonElement;
    viewButtons = document.querySelectorAll('.view-button')as NodeListOf<HTMLButtonElement>;
    createPostButton = document.querySelector('#create-post-button') as HTMLButtonElement;
    editBlogPostButton = document.querySelector('#edit-blog-post-button') as HTMLButtonElement;
    deleteCommentButtons = document.querySelectorAll('.delete-comment-button') as NodeListOf<HTMLButtonElement>;
    backToBlogButton = document.querySelector('#back-to-blog-button') as HTMLButtonElement;

    newTagButton = document.querySelector('#new-tag-button') as HTMLElement;
    clearTagButton = document.querySelector('#clear-tag-button') as HTMLElement;

    tabs = document.querySelectorAll('.tab') as NodeListOf<HTMLElement>;

    worldNameInput = document.querySelector('#world-name') as HTMLInputElement;
    shortNameInput = document.querySelector('#short-name') as HTMLInputElement;
    worldId = (document.querySelector('#world_id') as HTMLInputElement)?.value;
    assetType = (document.querySelector('#asset_type') as HTMLInputElement)?.value;

    addNewElement = (element: HTMLElement, elName: string) => {
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
                        if (option.value === (e.target as HTMLOptionElement)?.value) {
                            option.selected = !option.selected;
                        }
                    };
                });
            });
        }

        if (this.formInputs && this.submitButton) {
            let requiredInputs = [...this.formInputs].filter(input => input.required);
            let disableSubmitButton = () => {
                this.submitButton.disabled = !requiredInputs.every(input => input.value.trim().length > 0);
            };
            setTimeout(disableSubmitButton, 1000);
            requiredInputs.forEach(input => {
                input.oninput = ((oldOnInput) => {
                    return (e) => {
                        oldOnInput && oldOnInput(e);
                        disableSubmitButton();
                    };
                })(input.oninput?.bind(input));
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
                })(form.onsubmit?.bind(form));
            });
        }

        window.onbeforeunload=((oldBeforeUnload) => {
            return (e) => {
                oldBeforeUnload && oldBeforeUnload(e);
                if (this.formInputs.length == 0) return;
                if (this.submitted) {
                    StorageBox.clear();
                    return;
                }

                let values: {
                    [index: string]: string
                } = {};
                this.formInputs.forEach(input => {
                    if (input && input.name && !input.name.startsWith('_') && input.type !== 'file')
                        values[input.name] = input.value;
                });

                let content = window.tinymce.get('content')?.getContent() ?? '';
                let message = window.tinymce.get('message')?.getContent() ?? '';
                let description = window.tinymce.get('description')?.getContent() ?? '';

                StorageBox.set('formValues', values);
                StorageBox.set('content', content);
                StorageBox.set('message', message);
                StorageBox.set('description', description);
            }
        })(window.onbeforeunload?.bind(window));
        window.onload=((oldLoad) => {
            return (e) => {
                oldLoad && oldLoad(e);
                if (this.formInputs.length == 0) return;

                let values = StorageBox.get('formValues');
                let content = StorageBox.get('content');
                let message = StorageBox.get('message');
                let description = StorageBox.get('description');

                this.formInputs.forEach(input => {
                    if (input && input.name && !input.name.startsWith('_') && values && values[input.name] && input.type !== 'file')
                        input.value = values[input.name];
                });

                if (content && content !== undefined && content !== '') window.tinymce.get('content')?.setContent(content);
                if (message && message !== undefined && message !== '') window.tinymce.get('message')?.setContent(message);
                if (description && description !== undefined && description !== '') window.tinymce.get('description')?.setContent(description);

                localStorage.clear();
            }
        })(window.onload?.bind(window));

        if (CookieJar.get('cookies-are-cool')) {
            this.cookieBanner.style.display = 'none';
        } else {
            this.cookieBanner.style.display = 'flex';
        };

        if (this.cookieBannerButton) {
            this.cookieBannerButton.onclick = () => {
                CookieJar.set('cookies-are-cool', true, new Date(new Date().getFullYear() + 999, 0).toUTCString());
                this.cookieBanner.style.display = 'none';
            };
        }

        if (document.querySelectorAll('div, body')) {
            (document.querySelectorAll('div, body') as NodeListOf<HTMLDivElement> | NodeListOf<HTMLBodyElement>).forEach((div: HTMLDivElement | HTMLBodyElement) => {
                if (div.getAttribute('bg'))
                    div.style.backgroundImage = `url(${div.getAttribute('bg')})`;
            })
        }
    }
    [index: string]: string | boolean | HTMLElement | NodeListOf<HTMLElement> | HTMLCollectionOf<HTMLElement> | (() => HTMLElement) | ((element: HTMLElement, elName: string) => void) | null;
};
