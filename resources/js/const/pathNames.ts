export default class PathNames {
    public static readonly HOME = '/';
    public static readonly LOGIN = '/login';
    public static readonly BLOG = '/blog';
    public static readonly BLOG_CREATE = '/blog/create';
    public static readonly TAG = '/tag';
    public static readonly TAG_CREATE = '/tag/create';
    public static readonly ABOUT = '/about';
    public static readonly CONTACT = '/contact';
    public static readonly TOS = '/tos';
    public static readonly PRIVACY = '/privacy';
    public static readonly INFINITE_SCROLL = '/infinite-scroll';
    public static readonly MANY_WORLDS = '/many-worlds';

    static basePath = () => `\/${window.location.pathname.split(/[\/#?]/)[1]}`;
    static subdirectories = () => window.location.pathname.split(/[\/#?]/).slice(2);
};