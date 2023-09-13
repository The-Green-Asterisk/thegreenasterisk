export default class StorageBox {
    constructor() {
        //
    }

    static get(key) {
        let result = localStorage.getItem(key);
        if (result === 'true' || result === 'false') {
            return Boolean(result);
        } else if (!isNaN(Number(result))) {
            return Number(result);
        } else {
            try {
                return JSON.parse(result);
            } catch (e) {
                return result;
            };
        }
    }

    static set(key, value) {
        if (typeof value === 'object'){
            localStorage.setItem(key, JSON.stringify(value));
        } else {
            localStorage.setItem(key, value);
        };
    }

    static remove(key) {
        localStorage.removeItem(key);
    }

    static clear() {
        localStorage.clear();
    }
}