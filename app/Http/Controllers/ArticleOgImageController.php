<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleOgImageController
{
    public function __invoke(Article $article)
    {
        return response($article->ogImage())->header('Content-Type', 'image/png');
    }
}
