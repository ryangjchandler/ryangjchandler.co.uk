<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleOgImageController
{
    public function __invoke(Article $article)
    {
        // return view('articles.og-image', compact('article'));
        return response($article->ogImage())->header('Content-Type', 'image/jpeg');
    }
}
