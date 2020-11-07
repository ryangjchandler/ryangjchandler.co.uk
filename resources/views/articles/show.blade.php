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
    <link href="https://unpkg.com/nord-highlightjs@0.2.0/dist/nord.css" rel="stylesheet" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/kutty@latest/dist/tooltip.min.js"></script>
@endpush

@section('content')
    <article class="container max-w-2xl mx-auto py-24 px-4 md:px-0" itemid="#" itemscope itemtype="http://schema.org/BlogPosting">
        <div class="w-full mx-auto text-left mb-12">
            @if($article->series)
                <p class="mt-6 mb-2 text-primary uppercase tracking-wider font-semibold text-xs">
                    {{ $article->series->title }}
                </p>
            @endif
            <h1 class="text-3xl md:text-4xl text-gray-900 leading-tight mb-3 font-bold" itemprop="headline"
                title="{{ $article->formattedTitle() }}">
                {{ $article->formattedTitle() }}
            </h1>
            <div class="flex space-x-2 mb-6">
                @foreach($article->tags as $tag)
                    <a class="badge bg-gray-200 hover:bg-gray-400 text-gray-900" href="{{ $tag->url() }}">
                        {{ $tag->title }}
                    </a>
                @endforeach
            </div>
            <div class="flex space-x-4">
                <p class="text-base text-gray-700">{{ $article->published_at->format('F d, Y') }}</p>
                <span>&mdash;</span>
                <div class="flex items-center space-x-2 mb-6">
                    <p class="text-gray-700">Share this article</p>
                    <a x-data="tooltip()" x-spread="tooltip" x-position="top" title="Share on Twitter" class="text-gray-700 hover:text-gray-900"
                        href="https://twitter.com/share?text={{ $article->title }}&url={{ $article->url() }}" target="_blank" rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="h-5 w-5 flex-none" fill="currentColor">
                            <path
                            d="M19.633,7.997c0.013,0.175,0.013,0.349,0.013,0.523c0,5.325-4.053,11.461-11.46,11.461c-2.282,0-4.402-0.661-6.186-1.809	c0.324,0.037,0.636,0.05,0.973,0.05c1.883,0,3.616-0.636,5.001-1.721c-1.771-0.037-3.255-1.197-3.767-2.793	c0.249,0.037,0.499,0.062,0.761,0.062c0.361,0,0.724-0.05,1.061-0.137c-1.847-0.374-3.23-1.995-3.23-3.953v-0.05	c0.537,0.299,1.16,0.486,1.82,0.511C3.534,9.419,2.823,8.184,2.823,6.787c0-0.748,0.199-1.434,0.548-2.032	c1.983,2.443,4.964,4.04,8.306,4.215c-0.062-0.3-0.1-0.611-0.1-0.923c0-2.22,1.796-4.028,4.028-4.028	c1.16,0,2.207,0.486,2.943,1.272c0.91-0.175,1.782-0.512,2.556-0.973c-0.299,0.935-0.936,1.721-1.771,2.22	c0.811-0.088,1.597-0.312,2.319-0.624C21.104,6.712,20.419,7.423,19.633,7.997z"
                            />
                        </svg>
                    </a>
                    <a @click.prevent="navigator.clipboard.writeText(url) && ($el.title = 'Copied')"
                        x-data="{ ...tooltip(), url: '{{ $article->url() }}' }" x-spread="tooltip" x-position="top" title="Click to copy link to clipboard" class="text-gray-700 hover:text-gray-900 cursor-pointer">
                        <svg class="w-4 h-4 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="w-full mx-auto prose">
            {!! $article->parsedContent() !!}
        </div>
    </article>
@endsection
