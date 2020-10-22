<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleOgImageController
{
    public function __invoke(Request $request, Article $article)
    {
        if ($request->has('preview')) {
            return $article->ogImageHtml();
        }

        return response($article->ogImage())->header('Content-Type', 'image/png');
    }
}
