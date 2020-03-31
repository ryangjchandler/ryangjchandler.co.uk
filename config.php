<?php

return [

    'production' => false,

    'baseUrl' => 'http://ryangjchandler.co.uk.test',
    
    'title' => 'Ryan Chandler',
    
    'description' => 'The ramblings and thoughts of a young web developer.',

    'author' => 'Ryan Chandler',
    
    'collections' => [

        'posts' => [
            'path' => 'articles/{filename}',
            'sort' => '-date',
            'filter' => function ($post) {
                return $post->published;
            },
            'excerpt' => function ($post, $characters = 50) {
                return trim(substr(strip_tags($post->getContent()), 0, $characters)) . '...';
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
