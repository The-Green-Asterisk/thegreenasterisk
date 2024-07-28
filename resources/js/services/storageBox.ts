export default class StorageBox {
    constructor() {
        //
    }

    static get<T = null | string | boolean | number | object>(key: string): T {
        const result = localStorage.getItem(key);
        if (result === null) return null as T;
        if (result === 'true' || result === 'false') {
            return Boolean(result) as T;
        } else if (!isNaN(Number(result))) {
            return Number(result) as T;
        } else {
            try {
                return JSON.parse(result) as T;
            } catch (e) {
                return result as T;
            };
        }
    }

    static set(key: string, value: string | object | number | boolean): void {
        if (typeof value === 'object') {
            localStorage.setItem(key, JSON.stringify(value));
        } else {
            localStorage.setItem(key, value.toString());
        };
    }

    static remove(key: string): void {
        localStorage.removeItem(key);
    }

    static clear(): void {
        localStorage.clear();
    }
}