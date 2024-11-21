import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/login.css', // Thêm đường dẫn tệp CSS này
                'resources/js/app.js',
                'resources/js/loginPage.js',
                'resources/css/customer.css',
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',
        manifest: true,
    },
    optimizeDeps: {
        include: ['resources/css/customer.css'],
    },
});
