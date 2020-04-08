let mix = require('laravel-mix');
let build = require('./tasks/build.js');
require('laravel-mix-purgecss');

mix.disableSuccessNotifications();
mix.setPublicPath('source/assets/build');
mix.webpackConfig({
    plugins: [
        build.jigsaw,
        build.browserSync(),
        build.watch(['source/**/*.md', 'source/**/*.php', 'resources/views/**/*.php', 'source/**/*.scss', '!source/**/_tmp/*']),
    ]
});

mix
    .postCss('resources/css/main.css', 'css', [
        require('tailwindcss'),
    ])
    .purgeCss({
        content: ['./source/**/*.blade.php']
    })
    .version();
