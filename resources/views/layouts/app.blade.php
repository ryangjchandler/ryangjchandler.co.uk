@extends('layouts.master')

@section('body')
    @include('layouts.partials.header')

    @yield('content')

    @if($bannerAd = banner_ad())
        <div x-data="{ show: true }" x-show="show" x-cloak class="w-4/5 md:w-auto fixed shadow rounded-md bg-blue-100 mx-auto border-2 border-blue-300 p-4" style="bottom: 25px; left: 50%; transform: translateX(-50%)">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <a href="#" role="button" @click="show = false" class="mb-0 whitespace-no-wrap font-medium text-blue-400 hover:text-blue-6`00 transition ease-in-out duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                </div>
                <div class="ml-3 flex-1 flex justify-between">
                    <div class="banner-ad-content">
                        {!! $bannerAd->parsedContent() !!}
                    </div>
                    <p class="text-sm leading-5 mt-0 ml-3 md:ml-6">
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
