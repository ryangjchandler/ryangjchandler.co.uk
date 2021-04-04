<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('script:articles', function () {
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

Artisan::command('script:tags', function () {
    $tags = DB::table('tags')->get();

    $tags->each(function ($tag) {
        Category::updateOrCreate([
            'slug' => $tag->slug,
        ], [
            'title' => $tag->title,
        ]);

        $this->info('Transferred '.$tag->slug);
    });
});
