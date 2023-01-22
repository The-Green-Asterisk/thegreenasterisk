import './bootstrap';
import * as el from '@/js/constants/elements.js';
import '@/views/blog/blog.js';
import '@/views/components/navbar/navbar.js';
import '@/views/components/modal/modal.js';
import '@/views/components/tags/tags.js';


const { fetch: originalFetch } = window;
window.fetch = async (url, options = {}) => {
    el.loader.style.display = 'flex';
    options.headers
        ? options.headers['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        : options = {
            ...options,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        };
    const response = await originalFetch(url, options);
    el.loader.style.display = 'none';
    return response;
};
window.onload = () => {
    setTimeout(() => {
        el.loader.style.display = 'none';
    });
};

