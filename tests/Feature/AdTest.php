<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_a_pre_article_ad_is_shown_correctly()
    {
        $this->markTestSkipped();

        $article = Article::factory()->create();
        $ad = Ad::factory()->create();

        $this->get('/articles/'.$article->slug)
            ->assertSeeInOrder([
                'pre-article-ad',
                $ad->content,
                $article->title,
            ]);
    }

    public function test_that_a_banner_ad_is_shown_correctly()
    {
        $article = Article::factory()->create();
        $ad = Ad::factory()->banner()->create();

        $this->get('/articles/'.$article->slug)
            ->assertSeeInOrder([
                $article->title,
                'banner-ad-content',
                $ad->content,
            ]);
    }

    public function test_that_a_banner_ad_will_display_call_to_action_correctly()
    {
        $article = Article::factory()->create();
        $ad = Ad::factory()->banner('https://test.com')->create();

        $this->get('/articles/'.$article->slug)
            ->assertSeeInOrder([
                $article->title,
                'banner-ad-content',
                $ad->content,
                $ad->call_to_action,
            ]);
    }
}
