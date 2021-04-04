<?php

use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index', [
    'page' => Page::findOrFail('index'),
])->name('index');

Route::view('/posts', 'posts.index', [
    'posts' => Post::published()->simplePaginate(),
])->name('posts.index');

Route::get('/posts/{post:slug}', fn (Post $post) => view('posts.show', [
    'post' => $post,
]))->name('posts.show');

Route::get('/page/{page:slug}', fn (Page $page) => view('pages.show', [
    'page' => $page,
]))->name('pages.show');

Route::feeds();
