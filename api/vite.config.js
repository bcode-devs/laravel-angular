import {viteStaticCopy} from 'vite-plugin-static-copy'
import laravel from 'laravel-vite-plugin';
import {defineConfig} from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                __dirname + '/Modules/Shared/Resources/assets/sass/app.scss',
                __dirname + '/Modules/Shared/Resources/assets/js/app.js'
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: __dirname + '/Horizon/Shared/Resources/public/vendor',
                    dest: __dirname + '/public',
                },
            ],
        }),
    ],
});
