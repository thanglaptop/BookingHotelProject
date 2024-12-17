import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/customer.css', 
                'resources/css/login.css', 
                'resources/css/owner.css', 
                'resources/js/loginPage.js',
                'resources/js/customer.js',
                'resources/js/ddp.js',
                'resources/js/managepaymentinfo.js',
                'resources/js/owner.js',
                'resources/js/validatecustomerinfo.js',
                'resources/js/validateinput.js',
                'resources/js/validateinputhotel.js'
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
