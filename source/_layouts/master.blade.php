<!DOCTYPE html>
<html lang="{{ $page->language ?? 'en' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ $page->title }} - Ryan Chandler</title>
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
    </head>
    <body class="antialiased font-sans max-w-2xl mx-auto px-8 md:px-0">
        @include('_partials/_header')
        @yield('body')
    </body>
</html>
