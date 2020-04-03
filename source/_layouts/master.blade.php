<!DOCTYPE html>
<html lang="{{ $page->language ?? 'en' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="Ryan Chandler is a Laravel developer and wannabe writer.">
        <meta property="og:site_name" content="ryangjchandler.co.uk">
        <meta property="og:locale" content="en_GB">
        <meta property="og:description" content="Ryan Chandler is a Laravel developer and wannabe writer.">
        <meta property="og:url" content="https://ryangjchandler.co.uk">
	    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	    <link rel="manifest" href="/site.webmanifest">
        <script type='application/ld+json'>
            {
                "@context":"http:\/\/schema.org",
                "@type":"WebSite",
                "@id":"#website",
                "url":"https:\/\/ryangjchandler.co.uk\/",
                "name":"ryangjchandler.co.uk",
                "alternateName":"A developer blog about Laravel and other languages and frameworks."
            }
        </script>
        <script type='application/ld+json'>
            {
                "@context":"http:\/\/schema.org",
                "@type":"Person",
                "sameAs":["https:\/\/twitter.com\/ryangjchandler"],
                "@id":"#person",
                "name":"Ryan Chandler"
            }
        </script>
	    @stack('head')
        <title>@yield('title')</title>
        <link rel="webmention" href="https://webmention.io/ryangjchandler.co.uk/webmention" />
        <link rel="pingback" href="https://webmention.io/ryangjchandler.co.uk/xmlrpc" />
        <link href="https://fonts.googleapis.com/css?family=Inter:400,600,700,800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Fira+Code:500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
        <style>
            .hljs-comment,.hljs-meta{color:#969896}.hljs-emphasis,.hljs-quote,.hljs-string,.hljs-strong,.hljs-template-variable,.hljs-variable{color:#df5000}.hljs-keyword,.hljs-selector-tag,.hljs-type{color:#a71d5d}.hljs-attribute,.hljs-bullet,.hljs-literal,.hljs-symbol{color:#0086b3}.hljs-name,.hljs-section{color:#63a35c}.hljs-tag{color:#333}.hljs-attr,.hljs-selector-attr,.hljs-selector-class,.hljs-selector-id,.hljs-selector-pseudo,.hljs-title{color:#795da3}.hljs-addition{color:#55a532;background-color:#eaffea}.hljs-deletion{color:#bd2c00;background-color:#ffecec}.hljs-link{text-decoration:underline}
        </style>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
    </head>
    <body class="antialiased font-sans max-w-2xl mx-auto px-8 md:px-0">
        @include('_partials/_header')
        @yield('body')
        @include('_partials/_footer')
    </body>
</html>
