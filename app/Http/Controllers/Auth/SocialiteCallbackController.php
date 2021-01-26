<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialiteCallbackController extends Controller
{
    public function __invoke(string $provider)
    {
        $user = Socialite::driver($provider)->user();

        dd($user);
    }
}
