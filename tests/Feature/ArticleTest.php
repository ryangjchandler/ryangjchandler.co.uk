<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_an_article_can_be_viewed()
    {
        $article = Article::factory()->create();

        $this->get('/articles/'.$article->slug)
            ->assertStatus(200);
    }

    public function test_that_a_sponsors_only_article_cant_be_viewed_when_not_logged_in()
    {
        $article = Article::factory()->sponsorsOnly()->create();

        $this->get('/articles/'.$article->slug)
            ->assertRedirect('/login?sponsors_only=1');
    }

    public function test_that_a_sponsors_only_article_can_be_viewed_when_logged_in()
    {
        $this->login();

        $article = Article::factory()->sponsorsOnly()->create();

        $this->get('/articles/'.$article->slug)
            ->assertStatus(200);
    }
}
