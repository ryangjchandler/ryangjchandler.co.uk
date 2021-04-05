<?php

use App\Models\Byte;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index', [
        'page' => Page::findOrFail('index'),
    ]);
})->name('index');

Route::get('/posts', function (Request $request) {
    $posts = Post::published()
        ->when($request->has('category'), fn ($query) => $query->whereHas(
            'category', fn ($query) => $query->where('slug', $request->input('category'))
        ))
        ->published()
        ->simplePaginate();

    return view('posts.index', [
        'posts' => $posts,
        'category' => Category::find($request->input('category')),
    ]);
})->name('posts.index');

Route::get('/posts/{post:slug}', fn (Post $post) => view('posts.show', [
    'post' => $post,
]))->name('posts.show');

Route::get('/page/{page:slug}', fn (Page $page) => view('pages.show', [
    'page' => $page,
]))->name('pages.show');

Route::get('/articles/{post:slug}', fn (Post $post) => redirect('/posts/'.$post->slug, 301));

Route::get('/bytes', fn () => view('bytes.index', [
    'bytes' => Byte::latest('created_at')->simplePaginate(),
]))->name('bytes.index');

Route::feeds();
