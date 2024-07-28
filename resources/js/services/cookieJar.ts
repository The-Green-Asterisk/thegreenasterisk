type CookieObj = { [key: string]: object | string | boolean | number | null | undefined };
export default class CookieJar {
    static #kebabToCamelCase = (str: string) => {
        return str.replace(/-([a-z])/g, function (match, letter) {
            return letter.toUpperCase();
        });
    };

    /**
    * Returns all cookies as an object or the value of a specific cookie
    * @param {string?} cookieName
    * @return {object | string | boolean | number | null | undefined}
    */
    static get = <T = CookieObj>(cookieName: T extends CookieObj ? undefined : string): T extends CookieObj ? CookieObj : T => {
        const cookieObj: CookieObj = {};
        document.cookie.split(';').forEach(cookie => {
            cookieObj[this.#kebabToCamelCase(cookie.split('=')[0].trim())] =
                typeof cookie.split('=')[1] === 'string' && cookie.split('=')[1].startsWith('{')
                    ? JSON.parse(cookie.split('=')[1])
                    : typeof cookie.split('=')[1] === 'string' && (cookie.split('=')[1] === 'true' || cookie.split('=')[1] === 'false')
                        ? Boolean(cookie.split('=')[1])
                        : !isNaN(Number(cookie.split('=')[1]))
                            ? Number(cookie.split('=')[1])
                            : cookie.split('=')[1];
        });
        return cookieName
            ? cookieObj[this.#kebabToCamelCase(cookieName)] as T extends CookieObj ? CookieObj : T
            : Object.keys(cookieObj).length === 0 ? null as T extends CookieObj ? CookieObj : T : cookieObj as T extends CookieObj ? CookieObj : T;
    };

    /**
     * Sets a cookie
     * Use Date.ToUTCString() for expires
     * @param {string} cookieName 
     * @param {string | boolean | number | object} value 
     * @param {string} expires
     * @return {void}
     */
    static set = (cookieName: string, value: string | boolean | number | object, expires: string): void => {
        if (this.get<typeof value>(cookieName)) {
            this.delete(cookieName);
        }
        if (typeof value === 'object') {
            value = JSON.stringify(value);
        }
        document.cookie = `${cookieName}=${value}; expires=${expires};`;
    };

    /**
     * Deletes a cookie
     * @param {string} cookieName
     * @return {void}
     */
    static delete = (cookieName: string): void => {
        if (this.get<unknown>(cookieName)) {
            document.cookie = `${cookieName}=; expires=Thu, 01 Jan 1970 00:00:00 GMT;`;
        } else {
            console.error(`Cookie ${cookieName} does not exist.`);
        }
    };

    /**
     * Edits an existing cookie
     * Use Date.ToUTCString() for expires
     * @param {string} cookieName 
     * @param {string | boolean | number | object} value 
     * @param {string} expires 
     * @return {void}
     */
    static edit = (cookieName: string, value: string | boolean | number | object, expires: string): void => {
        if (this.get<typeof value>(cookieName)) {
            this.delete(cookieName);
            this.set(cookieName, value, expires);
        } else {
            console.error(`Cookie ${cookieName} does not exist.`);
        }
    };
}