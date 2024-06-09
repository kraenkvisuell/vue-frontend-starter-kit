import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2';
 
export default defineConfig({
    plugins: [
        laravel({
            valetTls: 'zwei-bags.test', 
            input: [
                'resources/css/app.css', 
                'resources/js/translatable.js'
            ],
            publicDirectory: 'resources/dist',
        }),
        vue(),
    ],
});
