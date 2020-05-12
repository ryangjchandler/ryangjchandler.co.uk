<?php

namespace App\Http\Controllers\Auth\GitHub;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class ProviderCallbackController
{
    public function __invoke()
    {
        $user = Socialite::driver('github')->user();

        $current = User::query()->where('email', $user->getEmail())->first();

        if (! $current) {
            $current = User::create([
                'name' => $user->getName(),
                'nickname' => $user->getNickname(),
                'email' => $user->getEmail(),
                'avatar' => $user->getAvatar(),
            ]);
        }

        auth()->login($current);

        return redirect()->route('home');
    }
}
