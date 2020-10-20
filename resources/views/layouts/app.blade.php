@extends('layouts.master')

@section('body')
@include('layouts.partials.header')

    <main class="max-w-4xl container px-4 mx-auto">
        <div class="pt-8 md:pt-24 pb-8">
            @if(session()->has('error'))
            <div x-data class="mb-4 mt-0 md:-mt-16 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                role="alert" x-ref="errorAlert">
                <strong class="font-bold">Oh no!</strong>
                <span class="block sm:inline">{!! session('error') !!}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="$refs.errorAlert.remove()">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <title>Close</title>
                        <path
                            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                    </svg>
                </span>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    @if($bannerAd = banner_ad())
        <div x-data="{ show: true }" x-show="show" x-cloak class="fixed shadow rounded-md bg-blue-100 mx-auto border-2 border-blue-300 p-4" style="bottom: 25px; left: 50%; transform: translateX(-50%)">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="#" role="button" @click="show = false" class="mb-0 whitespace-no-wrap font-medium text-blue-400 hover:text-blue-6`00 transition ease-in-out duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <div class="banner-ad-content">
                        {!! $bannerAd->parsedContent() !!}
                    </div>
                    <p class="mt-3 text-sm leading-5 md:mt-0 md:ml-6">
                        <a href="{{ $bannerAd->call_to_action }}?ref=ryangjchandler.co.uk"
                            class="whitespace-no-wrap font-medium text-blue-700 hover:text-blue-600 transition ease-in-out duration-150"
                            target="_blank"
                            rel="noopener noreferrer">
                            Details &rarr;
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endif

@endsection
