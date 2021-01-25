<link rel="stylesheet" href="{{ mix('css/app.css') }}">

@stack('style')

@if(app()->environment('production'))
    <!-- Fathom - beautiful, simple website analytics -->
    <script src="https://shrew.ryangjchandler.co.uk/script.js" site="FSVTNSHG" defer></script>
    <!-- / Fathom -->
    
    <!-- Umami - self-hosted, privacy-focused analytics -->
    <script async defer data-website-id="c79f67c1-bdef-433c-81f5-d9c1149a616f" src="https://analytics.ryangjchandler.co.uk/umami.js"></script>
    <!-- / Umami -->
@endif
