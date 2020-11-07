@extends('layouts.app')

@section('content')
    <section class="container max-w-5xl mx-auto py-24">
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
@endsection
