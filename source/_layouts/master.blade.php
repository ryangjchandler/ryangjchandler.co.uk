<!DOCTYPE html>
<html lang="{{ $page->language ?? 'en' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>@yield('title')</title>
        <link rel="webmention" href="https://webmention.io/ryangjchandler.co.uk/webmention" />
        <link rel="pingback" href="https://webmention.io/ryangjchandler.co.uk/xmlrpc" />
        <link href="https://fonts.googleapis.com/css?family=Inter:400,600,700,800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Fira+Code:500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
        <style>
            {{ (new GitDown\GitDown)->styles() }}
        </style>
    </head>
    <body class="antialiased font-sans max-w-2xl mx-auto px-8 md:px-0">
        @include('_partials/_header')
        @yield('body')
        @include('_partials/_footer')
    </body>
</html>
