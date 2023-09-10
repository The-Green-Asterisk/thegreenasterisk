import './bootstrap';

import pages from './pages';

import El from './const/elements';
import PathNames from './const/pathNames';

import { initLoader } from './services/request';

const elements = new El();
initLoader(elements);

switch (PathNames.basePath()) {
    case PathNames.HOME:
        pages.home(elements);
        break;
    case PathNames.BLOG:
        pages.blog(elements);
        break;
    case PathNames.ABOUT:
        pages.about(elements);
        break;
    case PathNames.CONTACT:
        pages.contact(elements);
        break;
    case PathNames.TOS:
        pages.tos(elements);
        break;
    case PathNames.PRIVACY:
        pages.privacy(elements);
        break;
    case PathNames.MANY_WORLDS:
        pages.manyWorlds(elements);
    default:
        break;
}