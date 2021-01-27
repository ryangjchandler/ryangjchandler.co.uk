<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cms;

Route::prefix('cms')->as('cms.')->middleware('auth')->group(function () {
    Route::get('/', Cms\IndexController::class)->name('index');
    Route::resource('posts', Cms\PostsController::class);
});
