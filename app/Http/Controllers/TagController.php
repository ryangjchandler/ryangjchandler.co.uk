<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TagController
{
    public function __invoke(Request $request, Tag $tag)
    {
        $date = request()->query('date');

        if ($date) {
            $date = Carbon::parse($date);
        }

        $query = $tag->articles()->latest('published_at')->published();

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
            'tag' => $tag,
            'tags' => Tag::all(),
        ]);
    }
}
