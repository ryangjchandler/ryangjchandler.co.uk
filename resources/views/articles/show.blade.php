@extends('layouts.app')

@section('title', $article->title)

@section('seo')
    <meta property="og:title" content="{{ $article->title }} - Ryan Chandler">
    <meta property="og:locale" content="en_GB">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $article->excerpt }}">

    <meta name="description" content="{{ $article->excerpt }}">
@endsection

@push('style')
    @if(! $article->show_toc)
        <style>
            .table-of-contents, .heading-permalink {
                display: none !important;
            }
        </style>
    @endif
@endpush

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
        @if($article->sponsors_only)
            <small class="mx-2 text-gray-400">|</small>
            <small class="bg-primary-200 text-primary-900 font-bold rounded px-2 py-1">Sponsors only</small>
        @endif
        @if($article->tags)
            <div class="mt-4">
                @foreach($article->tags as $tag)
                    <x-badge class="mr-2">{{ $tag->title }}</x-badge>
                @endforeach
            </div>
        @endif
        @if($article->series)
            <div class="rounded bg-primary-100 bg-opacity-50 px-5 py-4 mt-4">
                <p class="font-medium text-primary-800 mb-1">
                    This article is part of the <strong>{{ $article->series->title }}</strong> series.
                </p>
                <ol class="list-decimal pl-5 mt-2">
                    @foreach($article->series->articles as $seriesArticle)
                        <li class="@if(! $article->is($seriesArticle)) text-gray-600 @else text-primary-500 hover:text-primary-400 @endif">
                            @if($article->is($seriesArticle))
                                <p class="@if(! $loop->first) mt-2 @endif">{{ $seriesArticle->formattedTitle(true) }}</p>
                            @else
                                <a @if($seriesArticle->isPublished()) href="{{ route('articles.show', $seriesArticle) }}" @endif
                                    class="underline @if(! $loop->first) mt-2 @endif"
                                >
                                    {{ $seriesArticle->formattedTitle(true) }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>
        @endif
        <article class="@if($article->series) mt-4 @else mt-6 @endif w-full markup">
            {!! $article->parsedContent() !!}
        </article>
    </section>
@endsection
