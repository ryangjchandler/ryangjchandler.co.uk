<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'cacheResponse:86400'], function () {
    Route::get('/articles', 'ArticlesController@index')->name('articles.index');
    Route::get('/articles/{post:slug}', 'ArticlesController@show')->name('articles.show');
    Route::get('/categories', 'CategoriesController@index')->name('categories.index');
    Route::get('/categories/{category:slug}', 'CategoriesController@show')->name('categories.show');
    Route::get('/contact', 'ContactController')->name('contact');
    Route::get('/', 'IndexController')->name('index');
});

Route::feeds();
Route::redirect('/feed.xml', '/feed')->name('feed');
