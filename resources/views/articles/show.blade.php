@extends('layouts.app')

@section('title', $article->title)

@section('seo')
    <meta property="og:title" content="{{ $article->title }} - Ryan Chandler" />
    <meta property="og:locale" content="en_GB" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:description" content="{{ $article->excerpt }}" />
    <meta property="og:image" content="{{ $article->ogImageUrl() }}" />

    @foreach($article->tags as $tag)
        <meta property="article:tag" content="{{ $tag->title }}" />
    @endforeach

    <meta property="article:published_time" content="{{ optional($article->published_at)->toIso8601String() }}">
    <meta property="og:updated_time" content="{{ $article->updated_at->toIso8601String() }}" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="{{ $article->excerpt }}" />
    <meta name="twitter:title" content="{{ $article->title }} - Ryan Chandler" />
    <meta name="twitter:site" content="@ryangjchandler" />
    <meta name="twitter:image" content="{{ $article->ogImageUrl() }}" />
    <meta name="twitter:creator" content="@ryangjchandler" />

    <meta name="description" content="{{ $article->excerpt }}">
@endsection

@push('style')
    @if(! $article->show_toc)
        <style>
            .table-of-contents {
                display: none !important;
            }
        </style>
    @endif

    @if(! $article->allow_pdf_download)
        <style media="print">
            body { visibility: hidden !important; display: none !important; }
        </style>
    @endif
@endpush

@section('content')
    @if($preArticleAd = pre_article_ad())
        <div class="pre-article-ad">
            {!! $preArticleAd->parsedContent() !!}
        </div>
    @endif

    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">{{ $article->title }}</h2>
        <p class="md:text-lg text-gray-700 mb-4">{{ $article->excerpt}}</p>

        <div class="flex items-center print:hidden">
            @if($article->published_at)
                <small class="text-gray-600 font-medium">Published {{ $article->published_at->diffForHumans() }}</small>
                @if($article->updated_at->gt($article->published_at))
                    <span class="mx-2 text-gray-400">|</span>
                    <small class="text-gray-600 font-medium">Updated {{ $article->updated_at->diffForHumans() }}</small>
                @endif
            @endif

            @if($article->sponsors_only)
                <small class="mx-2 text-gray-400">|</small>
                <small class="bg-brand-primary-200 text-brand-primary-900 font-bold rounded px-2 py-1">Sponsors only</small>
            @endif

            @if($article->allow_pdf_download)
                <span class="mx-2 text-gray-400">|</span>

                <button x-data @click.prevent="window.print()" class="group flex items-center justify-between space-x-2 text-gray-400 hover:text-brand-primary-500 transition-colors ease-in-out duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <small class="text-gray-400 font-medium mb-0 group-hover:text-brand-primary-500 transition-colors ease-in-out duration-150">
                        Download as PDF
                    </small>
                </button>
            @endif
        </div>

        <div class="print:hidden">
            @if($article->tags)
                <div class="mt-4">
                    @foreach($article->tags as $tag)
                        <x-badge class="mr-2">{{ $tag->title }}</x-badge>
                    @endforeach
                </div>
            @endif
        </div>

        @if($article->series)
            <div class="rounded bg-brand-primary-100 bg-opacity-50 px-5 py-4 mt-4 print:hidden">
                <p class="font-medium text-brand-primary-800 mb-1">
                    This article is part of the <strong>{{ $article->series->title }}</strong> series.
                </p>
                <ol class="list-decimal pl-5 mt-2">
                    @foreach($article->series->articles as $seriesArticle)
                    <li
                        class="@if(! $article->is($seriesArticle)) text-gray-600 @else text-brand-primary-500 hover:text-brand-primary-400 @endif">
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

        <div class="mt-6 bg-brand-primary-400 rounded-lg px-4 py-2 font-medium text-sm text-gray-200">
            Got some feedback for me? Let me know on <a href="https://twitter.com/ryangjchandler" class="underline dotted hover:text-white">Twitter</a>, or send me an email at
            <a href="mailto:{{ $article->slug }}-feedback@ryangjchandler.co.uk" class="underline dotted hover:text-white">{{ $article->slug }}-feedback@ryangjchandler.co.uk</a>.
        </div>
    </section>
@endsection
