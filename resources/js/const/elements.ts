import CookieJar from "../services/cookieJar";
import StorageBox from "../services/storageBox";
import PathNames from "./pathNames";

type FormValues = { [key: string]: string };

export default class El {
    // Type Parameter (<Type> inside angle brackets) is only necessary when the element type is ambiguous
    root = document.querySelector<HTMLElement>(':root');
    crfToken = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
    cookieBanner = document.querySelector<HTMLDivElement>('#cookie-banner');
    cookieBannerButton = document.querySelector<HTMLButtonElement>('#cookie-banner-button');
    body = document.querySelector('body');
    loader = document.querySelector<HTMLDivElement>('#loader');
    navbar = document.querySelector<HTMLElement>('navbar');
    logInButton = document.querySelectorAll<HTMLAnchorElement>('#log-in-button');
    logOutButton = document.querySelector<HTMLAnchorElement>('#log-out-button');
    forms = document.querySelectorAll('form');
    inputs = document.querySelector('input');
    formInputs = document.querySelectorAll<HTMLInputElement | HTMLTextAreaElement>('input, textarea');
    submitButton = document.querySelector<HTMLButtonElement>('button[type="submit"]');
    selectors = document.querySelectorAll('select');

    modal = document.querySelector<HTMLDivElement>('#modal');
    grabModal = () => this.modal = document.querySelector<HTMLDivElement>('#modal');

    //BLOG
    blogPane!: HTMLDivElement | null;
    imagePreview!: HTMLImageElement | null;
    image!: HTMLInputElement | null;
    cancelCreateButton!: HTMLButtonElement | null;
    cancelEditButton!: HTMLButtonElement | null;
    deleteButton!: HTMLButtonElement | null;
    viewButtons!: NodeListOf<HTMLButtonElement> | null;
    createPostButton!: HTMLButtonElement | null;
    editBlogPostButton!: HTMLButtonElement | null;
    deleteCommentButtons!: NodeListOf<HTMLButtonElement> | null;
    backToBlogButton!: HTMLButtonElement | null;
    newTagButton!: HTMLButtonElement | null;
    clearTagButton!: HTMLButtonElement | null;

    //MANY WORLDS
    tabs!: NodeListOf<HTMLDivElement> | null;
    worldNameInput!: HTMLInputElement | null;
    shortNameInput!: HTMLInputElement | null;
    worldId!: string;
    assetType!: string;

    addNewElement = <T extends HTMLElement = HTMLElement>(element: T, elName: string) => {
        this[elName] = element;
        console.info(`${elName} has been added to elements temporarily. Be sure to add it to the class before pushing to production!`);

        return element;
    };

    constructor(path: string) {
        switch (path) {
            case PathNames.HOME:
                break;
            case PathNames.BLOG:
                this.blogPane = document.querySelector<HTMLDivElement>('#blog-pane');
                this.imagePreview = document.querySelector<HTMLImageElement>('#image-preview');
                this.image = document.querySelector<HTMLInputElement>('#image');
                this.cancelCreateButton = document.querySelector<HTMLButtonElement>('#cancel-create-button');
                this.cancelEditButton = document.querySelector<HTMLButtonElement>('#cancel-edit-button');
                this.deleteButton = document.querySelector<HTMLButtonElement>('#delete-button');
                this.viewButtons = document.querySelectorAll<HTMLButtonElement>('.view-button');
                this.createPostButton = document.querySelector<HTMLButtonElement>('#create-post-button');
                this.editBlogPostButton = document.querySelector<HTMLButtonElement>('#edit-blog-post-button');
                this.deleteCommentButtons = document.querySelectorAll<HTMLButtonElement>('.delete-comment-button');
                this.backToBlogButton = document.querySelector<HTMLButtonElement>('#back-to-blog-button');
                this.newTagButton = document.querySelector<HTMLButtonElement>('#new-tag-button');
                this.clearTagButton = document.querySelector<HTMLButtonElement>('#clear-tag-button');
                break;
            case PathNames.ABOUT:
                break;
            case PathNames.CONTACT:
                break;
            case PathNames.TOS:
                break;
            case PathNames.PRIVACY:
                break;
            case PathNames.MANY_WORLDS:
                this.tabs = document.querySelectorAll<HTMLDivElement>('.tab');
                this.worldNameInput = document.querySelector<HTMLInputElement>('#world-name');
                this.shortNameInput = document.querySelector<HTMLInputElement>('#short-name');
                this.worldId = document.querySelector<HTMLInputElement>('#world_id')?.value ?? '';
                this.assetType = document.querySelector<HTMLInputElement>('#asset_type')?.value ?? '';
                this.cancelCreateButton = document.querySelector<HTMLButtonElement>('#cancel-create-button');
                this.deleteCommentButtons = document.querySelectorAll<HTMLButtonElement>('.delete-comment-button');
                break;
            default:
                break;
        }

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
                if (this.submitButton)
                    this.submitButton.disabled = !requiredInputs.every(input => input.value.trim().length > 0);
            };
            setTimeout(disableSubmitButton, 1000);
            requiredInputs.forEach(input => {
                input.oninput = ((oldOnInput: typeof input.oninput | undefined) => {
                    return (e) => {
                        if (oldOnInput) oldOnInput.call(input, e);
                        disableSubmitButton();
                    };
                })(input.oninput?.bind(input));
            });

            this.forms.forEach(form => {
                form.onsubmit = ((oldOnSubmit: typeof form.onsubmit | undefined) => {
                    form.submitButton = form.querySelector<HTMLButtonElement>('button[type="submit"]');
                    return (e) => {
                        if (oldOnSubmit) oldOnSubmit.call(form, e);
                        form.submitButton.disabled = true;
                        form.submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                        this.submitted = true;
                    }
                })(form.onsubmit?.bind(form));
            });
        }

        window.onbeforeunload = ((oldBeforeUnload: typeof window.onbeforeunload | undefined) => {
            return (e) => {
                if (oldBeforeUnload) oldBeforeUnload.call(window, e);
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
        window.onload = ((oldLoad: typeof window.onload | undefined) => {
            return (e) => {
                if (oldLoad) oldLoad.call(window, e);
                if (this.formInputs.length == 0) return;

                let values = StorageBox.get<FormValues>('formValues');
                let content = StorageBox.get<string>('content');
                let message = StorageBox.get<string>('message');
                let description = StorageBox.get<string>('description');

                this.formInputs.forEach(input => {
                    if (input && input.name
                        && !input.name.startsWith('_')
                        && input.type !== 'file'
                        && values && values[input.name]
                    ) input.value = values[input.name];
                });

                if (content && typeof content === 'string' && content !== '')
                    window.tinymce.get('content')?.setContent(content);
                if (message && typeof message === 'string' && message !== '')
                    window.tinymce.get('message')?.setContent(message);
                if (description && typeof description === 'string' && description !== '')
                    window.tinymce.get('description')?.setContent(description);

                localStorage.clear();
            }
        })(window.onload?.bind(window));

        if (this.cookieBanner) {
            if (CookieJar.get<boolean>('cookies-are-cool')) {
                this.cookieBanner.style.display = 'none';
            } else {
                this.cookieBanner.style.display = 'flex';
            }
        };

        if (this.cookieBannerButton) {
            this.cookieBannerButton.onclick = () => {
                CookieJar.set('cookies-are-cool', true, new Date(new Date().getFullYear() + 999, 0).toUTCString());
                if (this.cookieBanner)
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
