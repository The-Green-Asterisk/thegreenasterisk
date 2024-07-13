import El from '../const/elements';

export function initLoader(el: El) {
    window.fetch = ((oldFetch: ((input: RequestInfo | URL, init?: RequestInit | undefined) => Promise<Response>), input: RequestInfo | URL = '', init?: RequestInit | undefined) => {
        return async (url: RequestInfo | URL = input, options: RequestInit | undefined = init) => {
            el.loader.style.display = 'flex';
            if (!options) options = {} as RequestInit;
            options.headers
                ? options.headers['X-CSRF-TOKEN'] = el.crfToken
                : options = {
                    ...options,
                    headers: {
                        'X-CSRF-TOKEN': el.crfToken
                    }
                };
            const response = await oldFetch(url, options);
            el.loader.style.display = 'none';
            return response;
        }
    })(window.fetch);

    window.onload=((oldLoad) => {
        return (e) => {
            oldLoad && oldLoad(e);
            el.loader.style.display = 'none';
        }
    })(window.onload?.bind(window));
}

export default async function request(
    method: string,
    path: string,
    data: { [key: string]: string | Boolean | Number } | null = null,
    evalResult = true,
) {
    let payLoad;
    
    if (method !== 'GET') payLoad = {
        method,
        headers: { 
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data),
    };

    const routePostfix = await getPostfix(method, data);

    const response = await fetch(`${path}${routePostfix}`, payLoad);

    let result;
    if (evalResult) result = await response.json();

    return evalResult ? result : response;
}

async function getPostfix(method: string, data: { [key: string]: string | Boolean | Number } | null = null) {
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

export async function get(path: string, data: { [key: string]: string | Boolean | Number } | null = null) {
    return await request('GET', path, data);
}

export async function getHtml(path: string, data: { [key: string]: string | Boolean | Number } | null = null) {
    return await request('GET', path, data, false)
        .then(response => response.text());
}

export async function post(path: string, data: { [key: string]: string | Boolean | Number } | null = null) {
    return await request('POST', path, data);
}

export async function put(path: string, data: { [key: string]: string | Boolean | Number } | null = null) {
    return await request('PUT', path, data);
}

export async function del(path: string, data: { [key: string]: string | Boolean | Number } | null = null) {
    if (data?._method){
        data._method = 'DELETE';
    } else {
        data = {
            ...data,
            _method: 'DELETE'
        };
    }
    return await request('POST', path, data, false);
}