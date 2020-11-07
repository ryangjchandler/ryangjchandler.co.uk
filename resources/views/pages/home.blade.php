@extends('layouts.app')

@section('content')
    <section class="container max-w-5xl mx-auto py-16">
        <h2 class="text-3xl text-gray-900 leading-tight mb-2 font-extrabold">Featured Articles</h2>
        <p class="text-lg text-gray-600 mb-10">A few of my favourite articles from the last couple of months.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-12">
            @foreach($featured as $article)
            <div>
                <h2 class="text-gray-900 text-lg font-semibold mb-2">
                    <a href="{{ $article->url() }}" class="text-gray-900 hover:text-primary">
                        {{ $article->title }}
                    </a>
                </h2>
                <p class="text-sm text-gray-600 font-normal mb-3">
                    {{ $article->excerpt }}
                </p>
                <p class="text-sm text-gray-600 font-normal mb-3">
                    {{ $article->published_at->format('F d, Y') }}
                </p>
            </div>
            @endforeach
        </div>
    </section>
    <section class="container max-w-5xl mx-auto pb-16">
        <h2 class="text-3xl text-gray-900 leading-tight mb-2 font-extrabold">
            Latest Articles
        </h2>
        <p class="text-lg text-gray-600 mb-10">My five latest articles, for your enjoyment.</p>
        <div class="w-full">
            <div class="flex flex-col space-y-16">
                @foreach($latest as $article)
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="col-span-1 md:col-span-4">
                            <p class="text-sm text-gray-600 font-normal mb-2 -mt-1">{{ $article->published_at->format('F d, Y') }}</p>
                            <h2 class="text-gray-800 text-xl font-extrabold leading-snug mb-2">
                                <a href="{{ $article->url() }}" class="text-gray-900 hover:text-purple-700">
                                    {{ $article->title }}
                                </a>
                            </h2>
                            <p class="text-sm text-gray-600 font-normal mb-3">
                                {{ $article->excerpt }}
                            </p>
                            <div class="flex space-x-2 mb-6">
                                @foreach($article->tags as $tag)
                                    <a class="badge bg-gray-200 hover:bg-gray-400 text-gray-900" href="{{ $tag->url() }}">
                                        {{ $tag->title }}
                                    </a>
                                @endforeach
                            </div>
                            <a href="#" class="btn btn-light btn-sm">Read More</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
