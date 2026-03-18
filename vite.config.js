import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                // Agregamos todos los archivos de la carpeta pages
                'resources/js/pages/caja.js',
                'resources/js/pages/citas.js',
                'resources/js/pages/dashboard.js',
                'resources/js/pages/pacientes.js',
                'resources/js/pages/reportes.js',
                // Si tienes lógica global en componentes, también:
                'resources/js/componentes/global.js',
                'resources/js/pages/pacientes.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});