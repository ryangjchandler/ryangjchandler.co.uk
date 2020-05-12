<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;

class LoginController
{
    public function __invoke(LoginRequest $request)
    {
        $success = auth()->attempt($request->only('email', 'password'), $request->has('remember'));

        if (! $success) {
            return redirect()->back()->withErrors([
                'email' => 'An error occurred.',
            ]);
        }

        return redirect()->route('home');
    }
}
