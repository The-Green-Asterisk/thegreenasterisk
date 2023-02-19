import './bootstrap';
import * as el from '@/js/constants/elements.js';
import '@/views/blog/blog.js';
import '@/views/components/navbar/navbar.js';
import '@/views/components/modal/modal.js';
import '@/views/components/tags/tags.js';


const { fetch: originalFetch } = window;
window.fetch = async (url, options = {}) => {
    el.loader.style.display = 'flex';
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    options.headers
        ? options.headers['X-CSRF-TOKEN'] = token
        : options = {
            ...options,
            headers: {
                'X-CSRF-TOKEN': token
            }
        };
    const response = await originalFetch(url, options);
    el.loader.style.display = 'none';
    return response;
};
window.onload = () => {
    setTimeout(() => {
        el.loader.style.display = 'none';
    });
};

if (el.cookieBannerButton) {
    el.cookieBannerButton.addEventListener('click', () => {
        el.cookieBanner.style.display = 'none';
        document.cookie = 'cookies-are-cool=true; expires=Fri, 31 Dec 9999 23:59:59 GMT;';
    });
}

if (el.selectors && el.selectors.length > 0) {
    [...el.selectors].forEach(selector => {
        selector.addEventListener('mousedown', (e) => {
            e.preventDefault();
            selector.focus();
            if ([...el.options].includes(e.target)) {
                e.target.selected = !e.target.selected;
            }
        });
    });
}

if (el.formInputs && el.submitButton) {
    el.formInputs.forEach(input => {
        if (input.required) {
            input.addEventListener('input', () => {
                if ([...el.formInputs].every(input => input.value.length > 0)) {
                    el.submitButton.disabled = false;
                } else {
                    el.submitButton.disabled = true;
                }
            });
        }
    });
}
