<link rel="stylesheet" href="{{ mix('css/app.css') }}">

@stack('style')

@if(app()->environment('production'))
    <!-- Fathom - beautiful, simple website analytics -->
    <script src="https://shrew.ryangjchandler.co.uk/script.js" site="FSVTNSHG" defer></script>
    <!-- / Fathom -->
@endif
