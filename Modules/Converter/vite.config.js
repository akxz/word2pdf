// const dotenvExpand = require('dotenv-expand');
import dotenvExpand from 'dotenv-expand';
import dotenv from 'dotenv';

// dotenvExpand(require('dotenv').config({ path: '../../.env'/*, debug: true*/}));
dotenvExpand(dotenv.config({ path: '../../.env'/*, debug: true*/}));

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    build: {
        outDir: '../../public/build-converter',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel.default({
            publicDirectory: '../../public',
            buildDirectory: 'build-converter',
            input: [
                // __dirname + '/Resources/assets/sass/app.scss',
                __dirname + '/Resources/assets/css/app.css',
                __dirname + '/Resources/assets/js/app.js'
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
