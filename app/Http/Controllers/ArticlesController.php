<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ArticlesController
{
    public function index()
    {
        /** @var \Illuminate\Database\Eloquent\Collection $articles */
        $articles = Article::latest('published_at')->published()->withCount('likes')->get();

        return view('articles.index', [
            'articles' => $articles,
            'dates' => $articles->mapToGroups(function (Article $article) {
                return [$article->published_at->format('F Y') => $article->title];
            }),
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
