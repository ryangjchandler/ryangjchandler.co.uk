@extends('_layouts.master')

@section('title', $page->title . ' - Ryan Chandler')

@section('body')
    <section class="post-header">
        <h1 class="leading-normal mb-5">{{ $page->title }}</h1>
        <div class="text-sm -mt-2 text-gray-700 hover:text-gray-900 leading-normal mb-5">
            @yield('content')
        </div>
        @foreach($posts->filter(function ($post) use ($page) {
            return $post->categories ? in_array($page->getFilename(), $post->categories, true) : false;
        }) as $post)
            @include('_partials._post-card', ['post' => $post])
        @endforeach
    </section>
@endsection