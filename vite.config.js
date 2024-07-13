import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue()
    ],
    hmr: {
        host: 'localhost', // Use 'localhost' to avoid IPv6 issues
        port: 5173,
    },
    server: {
        host: '127.0.0.1', // This makes the server accessible externally
        port: 5173,
        watch: {
          usePolling: true,
        },
    },
});
