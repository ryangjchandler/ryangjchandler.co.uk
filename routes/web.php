<?php

use Illuminate\Support\Facades\Route;

Route::get('/articles', 'ArticlesController@index')->name('articles.index');
Route::get('/articles/{post:slug}', 'ArticlesController@show')->name('articles.show');
