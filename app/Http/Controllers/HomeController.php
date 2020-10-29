<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController
{
    public function __invoke()
    {
        abort(500);
        return view('pages.home', [
            'articles' => Article::latest('published_at')
                ->published()
                ->get(),
        ]);
    }
}
