export default class CookieJar {
    static #kebabToCamelCase = (str) => {
        return str.replace(/-([a-z])/g, function (match, letter) {
            return letter.toUpperCase();
        });
    };

    /**
    * Returns all cookies as an object or the value of a specific cookie
    * @param {string?} cookie
    * @return {object | string | boolean | number}
    */
    static get = (cookie) => {
        
        const cookieObj = {};
        document.cookie.split(';').forEach(cookie => {
            cookieObj[this.#kebabToCamelCase(cookie.split('=')[0].trim())] = 
                cookie.split('=')[1] === "true" || cookie.split('=')[1] === "false"
                    ? Boolean(cookie.split('=')[1])
                    : isNaN(Number(cookie.split('=')[1]))
                        ? cookie.split('=')[1]
                        : Number(cookie.split('=')[1]);
        });
        return cookie
            ? cookieObj[this.#kebabToCamelCase(cookie)]
            : cookieObj;
    };

    /**
     * Sets a cookie
     * Use Date.ToUTCString() for expires
     * @param {string} cookie 
     * @param {string | boolean | Number} value 
     * @param {string} expires
     * @return {void}
     */
    static set = (cookie, value, expires) => {
        if (this.get(cookie)) {
            this.delete(cookie);
        }
        document.cookie = `${cookie}=${value}; expires=${expires};`;
    };

    /**
     * Deletes a cookie
     * @param {string} cookie
     * @return {void}
     */
    static delete = (cookie) => {
        if (this.get(cookie)) {
            document.cookie = `${cookie}=; expires=Thu, 01 Jan 1970 00:00:00 GMT;`;
        } else {
            console.error(`Cookie ${cookie} does not exist.`);
        }
    };

    /**
     * Edits an existing cookie
     * Use Date.ToUTCString() for expires
     * @param {string} cookie 
     * @param {string | boolean | Number} value 
     * @param {string} expires 
     * @return {void}
     */
    static edit = (cookie, value, expires) => {
        if (this.get(cookie)) {
            this.delete(cookie);
            this.set(cookie, value, expires);
        } else {
            console.error(`Cookie ${cookie} does not exist.`);
        }
    };
}