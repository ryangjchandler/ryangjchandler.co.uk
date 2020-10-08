<?php

namespace App\Http\Controllers\Auth\GitHub;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

        if ($current->nickname !== $user->getNickname()) {
            $current->nickname = $user->getNickname();
        }

        if ($current->avatar !== $user->getAvatar()) {
            $current->avatar = $user->getAvatar();
        }

        if ($current->isDirty()) {
            $current->save();
        }

        auth()->login($current, true);

        if ($redirect = session('sponsors_intended_url')) {
            session()->forget('sponsors_intended_url');

            return redirect($redirect);
        }

        return redirect()->route('home');
    }
}
