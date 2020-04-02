@extends('_layouts.master')

@section('title', $page->title . ' - Ryan Chandler')

@section('body')
    <article>
        <div class="post-header">
            <h1 class="leading-normal mb-5">{{ $page->title }}</h1>
            <p class="text-sm md:text-base -mt-2 text-gray-700 hover:text-gray-900 leading-normal mb-5">
                📅 Published at <time datetime="{{ date('Y-m-d', $page->date) }}">{{ date('d, M Y', $page->date) }}</time>
            </p>
            <div class="mb-5">
                @include('_partials/_categories', ['post' => $page])
            </div>
        </div>
        <div class="markup mb-6">
            @yield('content')
        </div>
        <hr class="mb-6" />
        @include('_partials._post-pagination', ['post' => $page])
    </article>
@endsection
