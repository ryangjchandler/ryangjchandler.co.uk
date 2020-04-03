@extends('_layouts.master')

@section('title', $page->title . ' - Ryan Chandler')

@push('head')
    
@endpush

@section('body')
    <article>
        <div class="post-header">
            <h1 class="leading-normal mb-5">{{ $page->title }}</h1>
            <p class="text-sm md:text-base -mt-2 text-gray-700 hover:text-gray-900 leading-normal mb-5">
                📅 Published at <time datetime="{{ date('Y-m-d', $page->date) }}">{{ date('d, M Y', $page->date) }}</time>
            </p>
            <div class="mb-6">
                @include('_partials/_categories', ['post' => $page])
            </div>
        </div>
        @if($page->archived && carbon($page->archived_date)->isPast())
            <div class="mb-5">
                @include('_partials/_post-archived-notice', ['post' => $page])
            </div>
        @endif
        <div class="markup mb-6">
            @yield('content')
        </div>
        <hr class="mb-6" /> 
        <details>
            <summary>Webmentions</summary>
            <div class="pt-8">
                @forelse($page->webmentions() as $webmention)
                    <div class="mb-4">
                        <div class="flex items-center mb-4">
                            <img src="{{ $webmention->avatar() }}" alt="{{ $webmention->author->name}} Avatar" class="w-10 h-10 rounded-full mr-4">
                            <div class="flex flex-col md:flex-row">
                                <strong class="mr-4 tracking-wide mb-1 md:mb-0">
                                    <a href="{{ $webmention->author->url }}" target="_blank" rel="noopener noreferrer" class="underline">{{ $webmention->author->name }}</a>
                                    <a href="{{ $webmention->sourceUrl }}" target="_blank" rel="noopener noreferrer" class="underline">{{ $webmention->keyword }}</a>
                                </strong>
                                <time datetime="{{ $webmention->date->format('Y-m-d') }}" class="text-gray-600">{{ $webmention->date->format('d, M Y') }}</time>
                            </div>
                        </div>
                        @if($webmention->type !== 'repost-of')
                            {!! $webmention->content !!}
                        @endif
                    </div>
                    @if(! $loop->last)
                        <hr class="mb-4" />
                    @endif
                @empty
                    <div class="mb-4">
                        😞 There's no webmentions here yet.
                    </div>
                @endforelse
            </div>
        </details>
        <hr class="my-6" />
        @include('_partials._post-pagination', ['post' => $page])
    </article>
@endsection
