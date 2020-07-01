<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ArticlesController
{
    public function index()
    {
        $date = request()->query('date');

        if ($date) {
            $date = Carbon::parse($date);
        }

        $query = Article::latest('published_at')->published()->withCount('likes');

        if ($date) {
            $query->whereBetween('published_at', [
                $date->startOfMonth()->toDateTimeString(),
                $date->endOfMonth()->toDateTimeString(),
            ]);
        }

        return view('articles.index', [
            'articles' => $query->paginate(10),
            'dates' => Article::latest('published_at')->published()->get()->mapToGroups(function (Article $article) {
                return [$article->published_at->format('F Y') => $article->id];
            }),
        ]);
    }

    public function show(Article $article)
    {
        $article->load(['comments' => function (MorphMany $comments) {
            $comments->latest('updated_at');
        }, 'likes', 'comments.user', 'series', 'series.articles' => function (HasMany $articles) {
            $articles->latest('published_at');
        }]);

        return view('articles.show', [
            'article' => $article,
        ]);
    }
}
