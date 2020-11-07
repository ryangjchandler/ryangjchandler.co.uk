<html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <div class="flex items-center justify-center" style="font-family: 'Poppins', sans-serif; width: 1200px; height: 600px;">
            <img src="{{ asset('img/og-image-bg.png') }}" width="1200px" height="600px" class="absolute z-0">
            <div style="width: 750px; height: 234px;" class="flex flex-col items-center justify-center z-50 absolute z-50">
                @if($article->series && $article->show_series_title_in_og_image)
                    <h1 class="text-center mb-3" style="font-size: 34px">
                        {{ $article->series->title }}
                    </h1>
                    <h2 class="text-center" style="font-size: 22px">
                        {{ $article->formattedTitle() }}
                    </h2>
                @else
                    <h1 class="text-center" style="font-size: {{ str_word_count($article->formattedTitle()) > 10 ? '30px' : '45px' }}">
                        {{ $article->formattedTitle() }}
                    </h1>
                @endif
            </div>
        </div>
    </body>
</html>
