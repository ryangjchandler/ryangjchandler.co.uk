<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\Auth\GitHub\ProviderCallbackController;
use App\Http\Controllers\Auth\GitHub\ProviderRedirectController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreCommentController;
use App\Http\Controllers\StoreLikeController;
use App\Http\Middleware\RedirectIfNotSponsor;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::view('/supporting-me', 'pages.support')->name('support');

Route::middleware('guest')->group(function () {
    Route::view('/register', 'pages.auth.register')->name('register');
    Route::post('/register', RegisterController::class)->name('register.submit');
    Route::view('/login', 'pages.auth.login')->name('login');
    Route::post('/login', LoginController::class)->name('login.submit');
    Route::get('/login/github', ProviderRedirectController::class)->name('login.github');
    Route::get('/login/github/callback', ProviderCallbackController::class)->name('login.github.submit');
});

Route::get('/articles', [ArticlesController::class, 'index'])->name('articles.index');

Route::get('/articles/{article:slug}', [ArticlesController::class, 'show'])
    ->middleware(RedirectIfNotSponsor::class)
    ->name('articles.show');

Route::post('/articles/{article:slug}/likes', StoreLikeController::class)
    ->middleware(RedirectIfNotSponsor::class)
    ->name('articles.likes.store');

Route::middleware('auth')->group(function () {
    Route::post('/articles/{article:slug}/comments', StoreCommentController::class)
        ->middleware(RedirectIfNotSponsor::class)
        ->name('articles.comments.store');

    Route::post('logout', LogoutController::class)->name('logout.submit');
});

Route::feeds();

