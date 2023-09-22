export function initLoader(el) {
    window.fetch=((oldFetch, input, init) =>{
        return async (url = input, options = init | undefined) => {
            el.loader.style.display = 'flex';
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
        return () => {
            oldLoad && oldLoad();
            el.loader.style.display = 'none';
        }
    })(window.onload);
}

export default async function request(
    method,
    path,
    data,
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

async function getPostfix(method, data) {
    let postfix = '';
    if (data && method === 'GET') {
        const params = new URLSearchParams();
        Object.keys(data).forEach(key => {
            params.append(key, data[key]);
        });
        postfix = `?${params.toString()}`;
    }
    return postfix;
}

export async function get(path, data) {
    return await request('GET', path, data);
}

export async function getHtml(path, data) {
    return await request('GET', path, data, false)
        .then(response => response.text());
}

export async function post(path, data) {
    return await request('POST', path, data);
}

export async function put(path, data) {
    return await request('PUT', path, data);
}

export async function del(path, data) {
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