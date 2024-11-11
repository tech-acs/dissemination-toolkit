import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import { createRequire } from 'node:module';
const require = createRequire( import.meta.url );
import ckeditor5 from '@ckeditor/vite-plugin-ckeditor5';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',

                'resources/css/content-styles.css',
                'resources/css/grid.css',
                'resources/css/markdown-editor.css',

                'resources/js/ChartEditor/index.jsx',
            ],
            refresh: true,
        }),
        react(),
        ckeditor5( { theme: require.resolve( '@ckeditor/ckeditor5-theme-lark' ) } )
    ],
    define: {
        global: {}
    },
    build: {
        target: "ES2022"
    },
});
