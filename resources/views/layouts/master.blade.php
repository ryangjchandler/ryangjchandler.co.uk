<html>
    <head>
        @include('layouts.partials.head')
        <style>{!! file_get_contents(resource_path('css/style.css')) !!}</style>
    </head>
    <body>
        @include('layouts.partials.header')
        @yield('body')
    </body>
</html>
