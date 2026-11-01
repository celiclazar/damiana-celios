import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    server: {
        cors: true,
        host: '0.0.0.0',
        allowedHosts: true,
    },
    plugins: [
        laravel({
            input: [
                'resources/css/filament/admin/theme.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
