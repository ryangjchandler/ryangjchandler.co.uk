<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function preArticle()
    {
        return $this->state([
            'type' => 'pre-article',
        ]);
    }

    public function banner(string $callToAction = null)
    {
        return $this->state([
            'type' => 'banner',
            'call_to_action' => $callToAction,
        ]);
    }

    public function definition()
    {
        return [
            'content' => $this->faker->text(25),
            'start_at' => now(),
            'end_at' => now(),
        ];
    }
}
