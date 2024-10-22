import './bootstrap';

import pages from './pages';
import constants from './const';

import { initLoader } from './services/request';

const elements = new constants.El(constants.PathNames.basePath());
initLoader(elements);

switch (constants.PathNames.basePath()) {
    case constants.PathNames.HOME:
        pages.home(elements);
        break;
    case constants.PathNames.BLOG:
        pages.blog(elements);
        break;
    case constants.PathNames.ABOUT:
        pages.about(elements);
        break;
    case constants.PathNames.CONTACT:
        pages.contact(elements);
        break;
    case constants.PathNames.TOS:
        pages.tos(elements);
        break;
    case constants.PathNames.PRIVACY:
        pages.privacy(elements);
        break;
    case constants.PathNames.MANY_WORLDS:
        pages.manyWorlds(elements);
    default:
        break;
}