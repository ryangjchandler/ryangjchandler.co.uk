const mix = require('laravel-mix');

mix.postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss')
])

mix.version()

