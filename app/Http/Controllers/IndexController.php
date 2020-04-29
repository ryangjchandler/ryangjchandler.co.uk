<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return view('articles.index', [
            'posts' => Cache::rememberForever('all_posts', function () {
                return Post::all();
            }),
        ]);
    }
}
