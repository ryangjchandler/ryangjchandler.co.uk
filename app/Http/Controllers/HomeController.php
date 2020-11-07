<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController
{
    public function __invoke()
    {
        return view('pages.home', [
            'featured' => Article::query()
                ->published()
                ->featured()
                ->limit(3)
                ->get(),
            'latest' => Article::query()
                ->published()
                ->featured()
                ->limit(5)
                ->get(),
        ]);
    }
}
