import { router } from "../router";

const API_BASE_URL = ( import.meta.env.VITE_BACKEND_URL ?? '/').replace(/\/$/, '');

export function apiUrl(url: string): string {
    return API_BASE_URL + '/' + url.replace(/^\//, '')
}

type FetchOptions = Omit<RequestInit, 'body'|'params'> & {body?: any, params?: any};

export async function apiFetch(url: string, fetchOptions?: FetchOptions){
    let response;

    url = apiUrl(url);

    if (fetchOptions) {
        if (('method' in fetchOptions) && (fetchOptions.method != 'GET')) {
            fetchOptions.headers ??= {}
            if (('body' in fetchOptions) && !(fetchOptions.body instanceof FormData)) {
                fetchOptions.headers = {...fetchOptions.headers, 'Content-Type': 'application/json'};
                fetchOptions.body = JSON.stringify(fetchOptions.body);
            }
        }

        if ('params' in fetchOptions) {
            url += `?${(new URLSearchParams(fetchOptions.params)).toString()}`

            fetchOptions.params = undefined
        }
    } else {
        fetchOptions = {}
    }

    fetchOptions.credentials = 'include';

    response = await fetch(url, fetchOptions);

    if (response?.status === 204)
        return null;

    if (response.status === 401) {
        throw new Error('unauthorized');
    }

    return await response?.json();
}


export async function apiPostRaw(url: string, body: string|Blob="", params: any ={}) {

    let response;

    url = apiUrl(url);

    if (params) {
        url += `?${(new URLSearchParams(params)).toString()}`
    }

    response = await fetch(url, {
        method: 'POST',
        credentials: 'include',
        body
    });

    if (response?.status === 401 && location.pathname != '/login') {
        router.push('/login')
    }

    if (response?.status === 204)
        return null;

    return await response?.json();
}