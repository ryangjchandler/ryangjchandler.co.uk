<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteCallbackController extends Controller
{
    public function __invoke(string $provider)
    {
        $socialite = Socialite::driver($provider)->user();

        $user = User::query()->updateOrCreate([
            'email' => $socialite->getEmail()
        ], [
            'name' => $socialite->getName(),
        ]);

        Auth::login($user, true);

        return redirect()->route('index');
    }
}
