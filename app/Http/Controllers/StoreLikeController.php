<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class StoreLikeController
{
    public function __invoke(Article $article)
    {
        $article->likes()->create();

        return redirect()->back();
    }
}
