<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

if (! function_exists('active_classes')) {
    function active_classes(string $route, array $classes)
    {
        if ($route === Route::getCurrentRoute()->getName()) {
            return implode(' ', $classes);
        }
    }
}

if (! function_exists('random_greeting')) {
    function random_greeting()
    {
        return Arr::random([
            'What\'s crackin\'?',
            'Aloha!',
            'What\'s good?',
            'Greetings!',
            'Hello!',
            'Wassup?',
            'Hello, World!',
        ]);
    }
}
