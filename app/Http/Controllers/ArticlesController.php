<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticlesController
{
    public function index()
    {
        return view('articles.index', [
            'articles' => Article::published()->get(),
        ]);
    }

    public function show(Article $article)
    {
        return view('articles.show', [
            'article' => $article,
        ]);
    }
}
