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
        <div>
            <x-form-button action="{{ route('articles.likes.store', $article) }}" buttonClasses="flex items-center text-red-500 border-2 border-red-500 rounded px-4 py-1">
                <svg class="w-8 h-8 m-0 p-0" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                <span class="ml-2 font-semibold">Click to Like</span>
            </x-form-button>
        </div>
        @auth
            @include('partials.article-comments-form')
        @else
            <div class="my-4 pl-4 py-4 pr-6 bg-primary-300 border-b-2 border-primary-400 bg-opacity-50 rounded-t-lg">
                <div class="flex items-start">
                    <p>
                        You need to <a href="{{ route('login') }}" class="font-semibold underline dotted text-primary-700">login</a> before commenting,
                        or <a href="{{ route('register') }}" class="font-semibold underline dotted text-primary-700">click here</a> to create an account.
                    </p>
                </div>
            </div>
        @endif
        @include('partials.article-comments')
    </section>
@endsection
