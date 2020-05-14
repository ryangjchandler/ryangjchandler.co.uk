<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController
{
    public function __invoke()
    {
        return view('pages.home', [
            'articles' => Article::withCount('likes')
                ->latest('published_at')
                ->published()
                ->get(),
        ]);
    }
}
