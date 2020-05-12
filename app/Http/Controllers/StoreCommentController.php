<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class StoreCommentController
{
    public function __invoke(Request $request, Article $article)
    {
        $article->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

        session()->flash('success', 'Comment successfully posted!');

        return redirect()->back();
    }
}
