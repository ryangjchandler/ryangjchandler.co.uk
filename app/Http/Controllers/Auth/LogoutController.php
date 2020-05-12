<?php

namespace App\Http\Controllers\Auth;

class LogoutController
{
    public function __invoke()
    {
        auth()->logout();

        return redirect()->route('home');
    }
}
