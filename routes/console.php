<?php

use App\Models\Post;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('script:transfer', function ($command) {
    $articles = DB::table('articles')->get();

    $articles->each(function ($article) {
        Post::updateOrCreate([
            'slug' => $article->slug,
        ], [
            'title' => $article->title,
            'excerpt' => $article->excerpt,
            'content' => $article->content,
            'published_at' => $article->published_at,
        ]);

        $this->info('Transferred '.$article->slug);
    });
});
