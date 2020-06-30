@extends('layouts.app')

@section('title', 'Articles')

@section('content')
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Articles</h2>
        <p class="md:text-lg text-gray-700">Or more accurately, word dumps.</p>
    </section>
    <section class="flex">
        <div class="w-3/4">
            @foreach($articles as $article)
                @include('partials.article-card')
            @endforeach
        </div>
        <aside class="flex flex-col align-end w-1/4">
            <h3 class="text-lg font-bold text-right text-gray-700 hover:text-gray-900">Archive</h3>
            @foreach($dates as $date => $items)
                <a href="?date={{ $date }}" class="text-right text-primary-400 hover:text-primary-600 hover:underline font-medium mt-4">
                    {{ $date }} ({{ $items->count() }})
                </a>
            @endforeach
        </aside>
    </section>
@endsection
