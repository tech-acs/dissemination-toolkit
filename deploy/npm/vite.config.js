import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig(() => {
    const inputs = [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/visualization.js',
        'resources/js/StoryBuilder.js',
        'resources/css/content-styles.css',
        'resources/css/grid.css',
        'resources/css/markdown-editor.css',
        'resources/css/map.css',
        'resources/css/editor.css',
        'resources/css/page-builder.css',
        'resources/js/ChartEditor/index.jsx'
    ];

    return {
        plugins: [
            laravel({
                input: inputs,
                refresh: true,
            }),
            react(),
        ],
        define: {
            global: {}
        },
        build: {
            rollupOptions: {
                output: {
                    manualChunks: (id) => {
                        if (id.includes('node_modules/react')) {
                            return 'react-vendor';
                        }
                    }
                }
            }
        },
    };
});
