<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.partials.meta')
    @include('layouts.partials.seo')

    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    @include('layouts.partials.style')
</head>
<body class="antialiased min-h-screen max-w-screen">
    @yield('body')

    @include('layouts.partials.footer')

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.x/dist/alpine.js"></script>
</body>
</html>
