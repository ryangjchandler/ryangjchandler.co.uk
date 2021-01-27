<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@isset($title) {{ $title }} - {{ config('app.name') }} @else {{ config('app.name') }} @endisset</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/awsm.css/dist/awsm.min.css">

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('cms.posts.index') }}">Posts</a>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    @routes
</body>
</html>
