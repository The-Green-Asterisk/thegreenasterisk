import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['/usr/local/var/www/thegreenasterisk/resources/css/app.css', '/usr/local/var/www/thegreenasterisk/resources/js/app.js'],
            refresh: true
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources',
        },
    },
});
