<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController
{
    public function __invoke()
    {
        return view('pages.home', [
            'featured' => Article::query()
                ->featured()
                ->limit(3)
                ->get(),
        ]);
    }
}
