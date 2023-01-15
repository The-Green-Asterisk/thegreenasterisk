import './bootstrap';
import * as el from '@/views/constants/elements.js';
import '@/views/components/navbar/navbar.js';
import '@/views/components/modal/modal.js';


const { fetch: originalFetch } = window;
window.fetch = async (url, options = {}) => {
    el.loader.style.display = 'flex';
    options.headers
        ? options.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        : options = { headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } };
    const response = await originalFetch(url, options);
    el.loader.style.display = 'none';
    return response;
};
