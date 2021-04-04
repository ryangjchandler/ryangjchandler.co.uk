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
        $category = Category::updateOrCreate([
            'slug' => $tag->slug,
        ], [
            'title' => $tag->title,
        ]);

        $articles = DB::table('article_tag')->where('tag_id', $tag->id)->get();

        $articles->each(function ($pivot) use ($category) {
            $article = DB::table('articles')->where('id', $pivot->article_id)->first();

            $post = Post::find($article->slug);

            $post->update(['category_slug' => $category->slug]);
        });

        $this->info('Transferred '.$tag->slug);
    });
});
