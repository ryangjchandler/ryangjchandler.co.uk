@extends('layouts.app')

@section('title', 'Articles')

@section('content')
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Articles</h2>
        <p class="md:text-lg text-gray-700">Or more accurately, word dumps.</p>
    </section>
    <section class="flex flex-col md:flex-row">
        <div class="w-3/4">
            @forelse($articles as $article)
                @include('partials.article-card')
            @empty
                <p class="font-medium text-gray-700">Nothing to see here. 😐</p>
            @endforelse

            <div class="mt-5">
                {{ $articles->links() }}
            </div>
        </div>
        <aside class="flex flex-col mt-24 | md:w-1/4 md:mt-0">
            <h3 class="text-lg font-bold md:text-right text-gray-700 hover:text-gray-900">Archive</h3>
            @foreach($dates as $date => $items)
                <a href="?date={{ $date }}" class="md:text-right text-primary-400 hover:text-primary-600 hover:underline font-medium mt-4">
                    {{ $date }} ({{ $items->count() }})
                </a>
            @endforeach
        </aside>
    </section>
@endsection
