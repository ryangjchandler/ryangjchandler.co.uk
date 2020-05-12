<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Http;

class RegisterController
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->userDetails());

        if ($request->has('subscribe')) {
            Http::withHeaders([
                'Authorization' => 'Token ' . config('services.buttondown.key'),
            ])->post(config('services.buttondown.url'), [
                'email' => $user->email,
            ]);
        }

        event(new Registered($user));

        auth()->login($user);

        return redirect()->route('home');
    }
}
