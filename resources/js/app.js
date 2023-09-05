import './bootstrap';

import components from './components';
import pages from './pages';

import El from './const/elements';
import PathNames from './const/pathNames';

import { initLoader } from './services/request';

const elements = new El();
initLoader(elements);

switch (PathNames.basePath()) {
    case PathNames.HOME:
        components.navbar(elements);
        components.modal(elements);
        break;
    case PathNames.BLOG:
        pages.blog(elements);
        components.navbar(elements);
        components.modal(elements);
        components.tags(elements);
        break;
    case PathNames.ABOUT:
    case PathNames.CONTACT:
    case PathNames.TOS:
    case PathNames.PRIVACY:
        components.navbar(elements);
        components.modal(elements);
        break;
    default:
        break;
}

if (elements.formInputs && elements.submitButton) {
    elements.formInputs.forEach(input => {
        if (input.required) {
            input.oninput = () => {
                if ([...elements.formInputs].every(input => input.value.length > 0)) {
                    elements.submitButton.disabled = false;
                } else {
                    elements.submitButton.disabled = true;
                }
            };
        }
    });
}
