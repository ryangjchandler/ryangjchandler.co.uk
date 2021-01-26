<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialiteRedirectController extends Controller
{
    public function __invoke(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }
}
