<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticlesController
{
    public function index()
    {
        return view('articles.index', [
            'articles' => Article::published()->withCount('likes')->get(),
        ]);
    }

    public function show(Article $article)
    {
        $article->load(['comments', 'likes', 'comments']);

        return view('articles.show', [
            'article' => $article,
        ]);
    }
}
