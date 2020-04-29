<?php

use Illuminate\Support\Facades\Route;

Route::get('/articles', 'ArticlesController@index')->name('articles.index');
Route::get('/articles/{post:slug}', 'ArticlesController@show')->name('articles.show');
Route::get('/categories', 'CategoriesController@index')->name('categories.index');
Route::get('/categories/{category:slug}', 'CategoriesController@show')->name('categories.show');
Route::feeds();
