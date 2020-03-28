@extends('_layouts.master')

@section('body')
    <article class="markup">
        <h1 class="leading-normal">{{ $page->title }}</h1>
        <p class="text-sm -mt-2 text-gray-700 hover:text-gray-900 leading-normal">
            Published at <time datetime="{{ date('Y-m-d', $page->date) }}">{{ date('j, M Y', $page->date) }}</time>
        </p>
        @yield('content')
    </article>
@endsection