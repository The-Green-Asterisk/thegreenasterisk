export default class StorageBox {
    constructor() {
        //
    }

    static get(key: string) {
        let result = localStorage.getItem(key);
        if (result === null) return null;
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

    static set(key: string, value: string | object | number | boolean) {
        if (typeof value === 'object'){
            localStorage.setItem(key, JSON.stringify(value));
        } else {
            localStorage.setItem(key, value.toString());
        };
    }

    static remove(key: string) {
        localStorage.removeItem(key);
    }

    static clear() {
        localStorage.clear();
    }
}