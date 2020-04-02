<?php

return [

    'production' => false,

    'baseUrl' => 'http://ryangjchandler.co.uk.test',
    
    'title' => 'Ryan Chandler',
    
    'description' => 'The ramblings and thoughts of a young web developer.',

    'author' => 'Ryan Chandler',

    'getVersion' => function () {
        return file_get_contents(__DIR__.'/.version');
    },
    
    'collections' => [

        'timeline' => [
            'sort' => '-date',
            'filter' => function ($timeline) {
                return $timeline->published;
            },
        ],

        'posts' => [
            'path' => 'articles/{filename}',
            'sort' => '-date',
            'filter' => function ($post) {
                return $post->published;
            },
            'excerpt' => function ($post, $characters = 50) {
                return trim(substr(strip_tags($post->getContent()), 0, $characters)) . '...';
            },
            'readingTime' => function ($post, int $wordsPerMinute = 160, bool $minutesOnly = true, bool $abbreviated = true) {
                $wordCount = str_word_count(strip_tags($post->getContent()));

                if ($wordsPerMinute <= 0) {
                    $wordsPerMinute = 200;
                }

                $minutes = (int) floor($wordCount / $wordsPerMinute);
                $seconds = (int) floor($wordCount % $wordsPerMinute / ($wordsPerMinute / 60));

                if ($minutesOnly && $minutes > 0 && $seconds >= 30) {
                    $minutes++;
                }

                if ($abbreviated) {
                    $strMinutes = 'min';
                    $strSeconds = 'sec';
                } else {
                    $strMinutes = $minutes === 1 ? 'minute' : 'minutes';
                    $strSeconds = $seconds === 1 ? 'second' : 'seconds';
                }

                if ($minutes === 0) {
                    return "{$seconds} {$strSeconds} read";
                }

                if ($minutesOnly) {
                    return "{$minutes} {$strMinutes} read";
                }

                return "{$minutes} {$strMinutes}, {$seconds} {$strSeconds} read";
            },
        ],

        'categories' => [
            'path' => 'categories/{filename}',
            'filter' => function ($category) {
                return $category->has_archive;
            },
        ],

    ],

];
