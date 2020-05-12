@hasSection('seo')
    @yield('seo')
@else
    <meta property="og:title" content="Ryan Chandler">
    <meta property="og:locale" content="en_GB">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:description" content="I'm a web developer from England. I build websites with Laravel and JavaScript.">

    <meta name="description" content="I'm a web developer from England. I build websites with Laravel and JavaScript.">
@endif
