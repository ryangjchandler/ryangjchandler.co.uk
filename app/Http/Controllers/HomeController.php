<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController
{
    public function __invoke()
    {
        return view('pages.home', [
            'articles' => Article::published()->get(),
        ]);
    }
}
