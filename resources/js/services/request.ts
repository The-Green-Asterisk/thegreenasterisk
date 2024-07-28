import { Method } from 'axios';
import El from '../const/elements';

type RequestData = { [key: string]: string | boolean | number };

export function initLoader(el: El) {
    window.fetch = ((oldFetch: typeof window.fetch, input: RequestInfo | URL = '', init?: RequestInit | undefined) => {
        return async (url: RequestInfo | URL = input, options: RequestInit | undefined = init) => {
            if (el.loader) el.loader.style.display = 'flex';
            if (!options) options = {} as RequestInit;
            options.headers
                ? options.headers['X-CSRF-TOKEN' as keyof HeadersInit] = el.crfToken
                : options = {
                    ...options,
                    headers: {
                        'X-CSRF-TOKEN': el.crfToken
                    }
                };
            const response = await oldFetch(url, options);
            if (el.loader) el.loader.style.display = 'none';
            return response;
        }
    })(window.fetch);

    window.onload = ((oldLoad: typeof window.onload | undefined) => {
        return (e) => {
            if (!!oldLoad) oldLoad.call(window, e);
            if (el.loader) el.loader.style.display = 'none';
        }
    })(window.onload?.bind(window));
}

export default async function request<T = Response>(
    method: Method,
    path: string,
    data: RequestData | null = null,
    evalResult = true,
 ): Promise<T extends Response ? Response : T> {
    let payLoad: RequestInit | undefined = undefined;

    if (method !== 'GET') payLoad = {
        method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        } as HeadersInit,
        body: JSON.stringify(data) as BodyInit,
    };

    const routePostfix = await getPostfix(method, data);

    const response = await fetch(`${path}${routePostfix}`, payLoad);

    return evalResult
        ? response.json().then(obj => obj as T extends Response ? Response : T)
        : response as T extends Response ? Response : T;
}

async function getPostfix(method: string, data: RequestData | null = null) {
    let postfix = '';
    if (data && method === 'GET') {
        const params = new URLSearchParams();
        Object.keys(data).forEach(key => {
            params.append(key, data[key].toString());
        });
        postfix = `?${params.toString()}`;
    }
    return postfix;
}

export async function get<T = Response>(path: string, data: RequestData | null = null) {
    return await request<T>('GET', path, data);
}

export async function getHtml(path: string, data: RequestData | null = null) {
    return await request('GET', path, data, false)
        .then(response => response.text());
}

export async function post<T = Response>(path: string, data: RequestData | null = null) {
    return await request<T>('POST', path, data);
}

export async function put<T = Response>(path: string, data: RequestData | null = null) {
    return await request<T>('PUT', path, data);
}

export async function del<T = Response>(path: string, data: RequestData | null = null) {
    if (data?._method) {
        data._method = 'DELETE';
    } else {
        data = {
            ...data,
            _method: 'DELETE'
        };
    }
    return await request<T>('POST', path, data, false);
}