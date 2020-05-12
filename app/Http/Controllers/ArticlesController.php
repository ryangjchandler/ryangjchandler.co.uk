<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
        $article->load(['comments' => function (MorphMany $comments) {
            $comments->latest('updated_at');
        }, 'likes', 'comments.user']);

        return view('articles.show', [
            'article' => $article,
        ]);
    }
}
