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
<body class="antialiased min-h-screen w-screen">
    @yield('body')

    <script type="module" src="{{ mix('js/index.js') }}"></script>
</body>
</html>
