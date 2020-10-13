<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function sponsorsOnly()
    {
        return $this->state([
            'sponsors_only' => true,
        ]);
    }

    public function definition()
    {
        return [
            'title' => $this->faker->text(10),
            'content' => $this->faker->text(200),
            'excerpt' => $this->faker->text(50),
        ];
    }
}
