@extends('layouts.app')

@section('title', 'Login')

@section('content')
    @if(request()->has('sponsors_only'))
    <div class="rounded-md bg-blue-50 p-4 -mt-10 mb-8">
        <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text-sm leading-5 text-blue-700">
                        This post is only available for my <a href="https://github.com/sponsors/ryangjchandler" class="underline" target="_blank" rel="noopener noreferrer">GitHub Sponsors</a>.
                    </p>

                    <p class="mt-3 text-sm leading-5 md:mt-0 md:ml-6">
                        <a href="{{ route('support') }}" class="whitespace-no-wrap font-medium text-blue-700 hover:text-blue-600 transition ease-in-out duration-150">
                            Details &rarr;
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endif

    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Login</h2>
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
