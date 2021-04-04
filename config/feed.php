<?php

use App\Models\Post;

return [
    'feeds' => [
        'main' => [

            'items' => Post::class.'@getFeedResults',

            'url' => '/feed',

            'title' => 'Ryan Chandler\'s blog',
            'description' => 'I\'m a Laravel and JavaScript developer from the south-east of the United Kingdom.',
            'language' => 'en-GB',

            'view' => 'feed::atom',

            'type' => 'application/atom+xml',
        ],
    ],
];
