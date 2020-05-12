@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Login</h2>
        <p class="md:text-lg mb-2">Comment on articles, download videos and more.</p>
    </section>
    <section class="max-w-md">
        <form action="{{ route('login.submit') }}" method="POST" class="mb-6">
            @csrf
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
            <div class="flex items-centerr justify-between">
                <label class="flex items-center mb-4">
                    <input type="checkbox" class="form-checkbox" name="remember" id="remember">
                    <span class="ml-2 text-gray-900">Remember me</span>
                </label>
                <div>
                    <a href="{{ route('register') }}" class="text-primary-600 font-medium underline dotted" title="No account">
                        No account?
                    </a>
                </div>
            </div>
            <button type="submit" class="w-full md:w-auto bg-primary-100 text-primary-600 font-bold px-6 py-2 rounded-t border-b border-primary-600">
                Login
            </button>
        </form>
        <hr />
        <div class="mt-6">
            <a href="{{ route('login.github') }}" class="bg-gray-900 rounded px-4 py-2 text-white font-bold">
                Login with GitHub
            </a>
        </div>
    </section>
@endsection
