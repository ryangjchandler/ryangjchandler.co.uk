@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">{{ $article->title }}</h2>
        <p class="md:text-lg text-gray-700 mb-4">{{ $article->excerpt}}</p>
        @if($article->published_at)
            <small class="text-gray-600 font-medium">Published {{ $article->published_at->diffForHumans() }}</small>
            @if($article->updated_at->gt($article->published_at))
                <span class="mx-2 text-gray-400">|</span>
                <small class="text-gray-600 font-medium">Updated {{ $article->updated_at->diffForHumans() }}</small>
            @endif
        @endif
        <small class="mx-2 text-gray-400">|</small>
        <small class="text-gray-600 font-medium">{{ $article->likes->count() }} likes</small>
        <article class="mt-6 w-full markup">
            {!! $article->content() !!}
        </article>
    </section>
    <section>
        @include('partials.article-comments')
    </section>
@endsection
