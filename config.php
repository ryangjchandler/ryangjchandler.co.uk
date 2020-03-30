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
            'sort' => 'date',
            'filter' => function ($post) {
                return $post->published;
            }
        ]
    ],

];
