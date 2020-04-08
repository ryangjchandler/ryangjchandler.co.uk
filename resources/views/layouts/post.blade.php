@extends('layouts::master')

@section('title', $page->title . ' - Ryan Chandler')

@section('body')
    <article>
        <div class="post-header">
            <h1 class="leading-normal mb-5 dark:text-gray-200">{{ $page->title }}</h1>
            <p class="text-sm md:text-base -mt-2 text-gray-700 hover:text-gray-900 leading-normal mb-5">
                📅 Published at <time datetime="{{ date('Y-m-d', $page->date) }}">{{ date('d, M Y', $page->date) }}</time>
            </p>
            <div class="mb-6">
                @include('partials::_categories', ['post' => $page])
            </div>
        </div>
        @if($page->archived && carbon($page->archived_date)->isPast())
            <div class="mb-5">
                @include('partials::_post-archived-notice', ['post' => $page])
            </div>
        @endif
        <div class="markup mb-6 dark:text-gray-400">
            @yield('content')
        </div>
        <hr class="mb-6" /> 
        @include('partials::_webmentions')
        <hr class="my-6" />
        @include('partials::._post-pagination', ['post' => $page])
    </article>
@endsection
