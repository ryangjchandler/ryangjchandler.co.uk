<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticlesController
{
    public function index()
    {
        return view('articles.index', [
            'articles' => Article::latest('published_at')->published()->get(),
        ]);
    }

    public function show(Article $article)
    {
        return view('articles.show', [
            'article' => $article,
        ]);
    }
}
