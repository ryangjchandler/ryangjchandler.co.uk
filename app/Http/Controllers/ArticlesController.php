<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Cache;

class ArticlesController
{
    public function index()
    {
        return view('articles.index', [
            'posts' => Cache::rememberForever('all_posts', function () {
                return Post::query()->latest('published_at')->get();
            }),
        ]);
    }

    public function show(Post $post)
    {
        return view('articles.show', [
            'post' => $post,
        ]);
    }
}
