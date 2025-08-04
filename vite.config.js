import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import statamic from './vendor/statamic/cms/resources/js/vite-plugin';
import vue from '@vitejs/plugin-vue';
import { viteExternalsPlugin } from 'vite-plugin-externals';

export default defineConfig({
    plugins: [
        statamic(),
        laravel({
            hotFile: 'dist/hot',
            publicDirectory: 'dist',
            input: ['resources/js/color-swatches.js', 'resources/css/color-swatches.css'],
        }),
        vue(),
        viteExternalsPlugin({
            vue: 'Vue',
            pinia: 'Pinia',
            'vue-demi': 'Vue',
        }),
    ],
    server: {
        hmr: false,
    },
});
