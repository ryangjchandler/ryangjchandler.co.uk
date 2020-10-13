<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function admin()
    {
        return $this->state([
            'admin' => true,
        ]);
    }

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'nickname' => $this->faker->userName,
            'password' => Hash::make('password'),
        ];
    }
}
