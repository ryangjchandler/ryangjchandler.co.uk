@props(['title'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('feed::links')
    <title>@isset($title) {{ $title }} - @endisset {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script
        src="https://analytics.ryangjchandler.co.uk/js/tracker.js"
        data-url="https://analytics.ryangjchandler.co.uk"
        data-site="93b485b6-7185-49a6-97f2-d55d303275bc"
        async
    ></script>
</head>
<body class="flex flex-col min-h-screen font-sans text-base antialiased min-w-screen">
    <header class="max-w-3xl p-8 space-y-4 md:space-y-8 md:px-32 md:pt-24 md:pb-16">
        <h1 class="text-xl font-bold text-gray-900 md:text-2xl">Ryan Chandler</h1>

        <nav class="space-x-8">
            <a href="{{ route('index') }}" class="text-sm md:text-base hover:underline focus:underline {{ active('index', 'underline text-gray-900 font-semibold', 'font-medium text-gray-600') }}">About</a>
            <a href="{{ route('posts.index') }}" class="text-sm md:text-base hover:underline focus:underline {{ active('posts.index', 'underline text-gray-900 font-semibold', 'font-medium text-gray-600') }}">Blog</a>
            <a href="{{ route('bytes.index') }}" class="text-sm md:text-base hover:underline focus:underline {{ active('bytes.index', 'underline text-gray-900 font-semibold', 'font-medium text-gray-600') }}">Bytes</a>

            @if(config('features.projects_enabled'))
                <a href="/" class="text-sm md:text-base hover:underline focus:underline {{ active('projects.index', 'underline text-gray-900 font-semibold', 'font-medium text-gray-600') }}">Projects</a>
            @endif
        </nav>
    </header>

    <main class="flex-1 max-w-4xl px-8 md:px-32">
        {{ $slot }}
    </main>

    <footer class="max-w-3xl px-8 py-4 space-y-4 md:space-y-8 md:px-32 md:py-12">
        <nav class="space-x-8">
            <a href="{{ route('pages.show', 'uses') }}" class="font-medium text-xs md:text-sm uppercase text-gray-400 hover:text-gray-600 {{ active('uses', 'underline text-gray-900 font-semibold') }}">Uses</a>
            <a href="/feed" class="font-medium text-xs md:text-sm uppercase text-gray-400 hover:text-gray-600 {{ active('uses', 'underline text-gray-900 font-semibold') }}">Feed</a>
            <a href="https://twitter.com/ryangjchandler" target="_blank" rel="noopener noreferrer" class="font-medium text-xs md:text-sm uppercase text-gray-400 hover:text-gray-600 {{ active('uses', 'underline text-gray-900 font-semibold') }}">Twitter</a>
            <a href="https://github.com/ryangjchandler" target="_blank" rel="noopener noreferrer" class="font-medium text-xs md:text-sm uppercase text-gray-400 hover:text-gray-600 {{ active('uses', 'underline text-gray-900 font-semibold') }}">GitHub</a>
        </nav>
    </footer>
</body>
</html>
