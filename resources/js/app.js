import './bootstrap';
import el from '@/js/const/elements';
import { initLoader } from '@/js/services/request';
import pathNames from '@/js/const/pathnames';
import pages from '@/js/pages';
import components from '@/js/components';

initLoader();

switch (`\/${window.location.pathname.split(/[\/#?]/)[1]}`) {
    case pathNames.HOME:
        components.navbar(el);
        components.modal(el);
        break;
    case pathNames.BLOG:
        pages.blog(el);
        components.navbar(el);
        components.modal(el);
        components.tags(el);
        break;
    case pathNames.ABOUT:
    case pathNames.CONTACT:
    case pathNames.TOS:
    case pathNames.PRIVACY:
        components.navbar(el);
        components.modal(el);
        break;
    default:
        break;
}

if (el.cookieBannerButton) {
    el.cookieBannerButton.onclick = () => {
        el.cookieBanner.style.display = 'none';
        document.cookie = 'cookies-are-cool=true; expires=Fri, 31 Dec 9999 23:59:59 GMT;';
    };
}

if (el.selectors && el.selectors.length > 0) {
    [...el.selectors].forEach(selector => {
        selector.onclick = (e) => {
            e.preventDefault();
            selector.focus();
            if ([...el.options].includes(e.target)) {
                e.target.selected = !e.target.selected;
            }
        };
    });
}

if (el.formInputs && el.submitButton) {
    el.formInputs.forEach(input => {
        if (input.required) {
            input.oninput = () => {
                if ([...el.formInputs].every(input => input.value.length > 0)) {
                    el.submitButton.disabled = false;
                } else {
                    el.submitButton.disabled = true;
                }
            };
        }
    });
}
