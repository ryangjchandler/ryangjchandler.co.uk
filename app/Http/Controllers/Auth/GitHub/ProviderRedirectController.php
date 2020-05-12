<?php

namespace App\Http\Controllers\Auth\GitHub;

use Laravel\Socialite\Facades\Socialite;

class ProviderRedirectController
{
    public function __invoke()
    {
        return Socialite::driver('github')->redirect();
    }
}
