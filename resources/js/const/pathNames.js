export default class PathNames {
    static HOME = '/';
    static LOGIN = '/login';
    static BLOG = '/blog';
    static BLOG_CREATE = '/blog/create';
    static TAG = '/tag';
    static TAG_CREATE = '/tag/create';
    static ABOUT = '/about';
    static CONTACT = '/contact';
    static TOS = '/tos';
    static PRIVACY = '/privacy';
    static INFINITE_SCROLL = '/infinite-scroll';

    static basePath = () => `\/${window.location.pathname.split(/[\/#?]/)[1]}`;
};