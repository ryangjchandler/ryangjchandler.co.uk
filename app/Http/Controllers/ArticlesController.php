<?php

namespace App\Http\Controllers;

use App\Post;

class ArticlesController
{
    public function index()
    {
        return view('articles.index', [
            'posts' => Post::published()->get(),
        ]);
    }

    public function show(Post $post)
    {
        return view('articles.show', [
            'post' => $post,
        ]);
    }
}
