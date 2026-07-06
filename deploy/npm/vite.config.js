import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(() => {
    const inputs = [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/visualization.js',
        'resources/css/grid.css',
        'resources/css/map.css'
    ];

    return {
        plugins: [
            laravel({
                input: inputs,
                refresh: true,
            }),
        ],
        define: {
            global: {}
        }
    };
});
