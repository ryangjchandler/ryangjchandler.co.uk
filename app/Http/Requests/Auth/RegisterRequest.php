<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string'
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
            'subscribe' => [
                'nullable',
            ]
        ];
    }

    public function passedValidation()
    {
        $this->merge([
            'password' => Hash::make($this->input('password')),
        ]);
    }

    public function userDetails()
    {
        return collect($this->validated())
            ->only('name', 'email', 'password')
            ->toArray();
    }
}
