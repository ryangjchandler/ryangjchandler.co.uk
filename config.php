<?php

use RyanChandler\DataObjects\Webmention;

return [

    'production' => false,

    'baseUrl' => 'http://ryangjchandler.co.uk.test',
    
    'title' => 'Ryan Chandler',
    
    'description' => 'The ramblings and thoughts of a young web developer.',

    'webmentions' => [
        'directory' => __DIR__ . './source/_webmentions',
        'url' => 'https://webmention.io/api/mentions.jf2',
        'domain' => env('WEBMENTIONS_DOMAIN'),
        'token' => env('WEBMENTIONS_TOKEN'),
        'per_page' => env('WEBMENTIONS_PER_PAGE', 999),
    ],

    'author' => 'Ryan Chandler',

    'getVersion' => function () {
        return file_get_contents(__DIR__.'/.version');
    },
    
    'collections' => [

        'timeline' => [
            'sort' => ['-date', 'order'],
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
            'webmentions' => function ($post) {
                $filePath = __DIR__.'/source/_webmentions/articles--' . $post->getFilename() . '.json';

                if (!file_exists($filePath)) {
                    return [];
                }

                return collect(
                    json_decode(file_get_contents($filePath), true)
                )->map(function ($webmention) {
                    return new Webmention($webmention);
                });
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
