@extends('layouts.app')

@section('title', $tag->title)

@section('content')
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">{{ $tag->title }}</h2>
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
            <div class="md:mb-4 md:text-right">
                <h3 class="text-lg font-bold md:text-right text-gray-700 hover:text-gray-900 mb-2">Tags</h3>
                @foreach($tags as $tag)
                    <a href="#">
                        <x-badge class="mb-2 hover:bg-primary-200">{{ $tag->title }}</x-badge>
                    </a>
                @endforeach
            </div>
            <div class="md:text-right">
                <h3 class="text-lg font-bold md:text-right text-gray-700 hover:text-gray-900">Archive</h3>
                @foreach($dates as $date => $items)
                    <a href="?date={{ $date }}" class="md:text-right text-primary-400 hover:text-primary-600 hover:underline font-medium mt-4">
                        {{ $date }} ({{ $items->count() }})
                    </a>
                @endforeach
            </div>
        </aside>
    </section>
@endsection
