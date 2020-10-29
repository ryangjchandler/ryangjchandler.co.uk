@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Register</h2>
        <p class="md:text-lg mb-2">Creating an account lets you comment on articles, download videos and more.</p>
    </section>
    <section class="max-w-md">
        <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            <label class="block mb-4">
                <span class="text-gray-900">Name</span>
                <x-input type="text" name="name" id="name" placeholder="Ryan Chandler" class="w-full block mt-2" />
                @error('name')
                    <span class="inline-block font-medium text-red-700 mt-2">{{ $message }}</span>
                @enderror
            </label>
            <label class="block mb-4">
                <span class="text-gray-900">Email Address</span>
                <x-input type="email" name="email" id="email" placeholder="mail@ryangjchandler.co.uk" class="w-full block mt-2" />
                @error('email')
                    <span class="inline-block font-medium text-red-700 mt-2">{{ $message }}</span>
                @enderror
            </label>
            <label class="block mb-4">
                <span class="text-gray-900">Password</span>
                <x-input type="password" name="password" id="password" placeholder="**********" class="w-full block mt-2" value="" />
                @error('password')
                    <span class="inline-block font-medium text-red-700 mt-2">{{ $message }}</span>
                @enderror
            </label>
            <label class="block mb-4">
                <span class="text-gray-900">Confirm Password</span>
                <x-input type="password" name="password_confirmation" id="password_confirmation" value=""
                    placeholder="**********" class="w-full block mt-2"
                />
            </label>
            <label class="flex items-center mb-4">
                <input type="checkbox" class="form-checkbox" name="subscribe" id="subscribe">
                <span class="ml-2 text-gray-900">Subscribe to weekly newsletter</span>
            </label>
            <button type="submit" class="w-full md:w-auto bg-brand-primary-100 text-brand-primary-600 font-bold px-6 py-2 rounded-t border-b border-brand-primary-600">
                Register
            </button>
        </form>
    </section>
@endsection
