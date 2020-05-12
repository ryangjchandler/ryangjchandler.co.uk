@extends('layouts.app')

@section('title', 'Articles')

@section('content')
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Articles</h2>
        <p class="md:text-lg text-gray-700">Or more accurately, word dumps.</p>
    </section>
    <section>
        @foreach($articles as $article)
            @include('partials.article-card')
        @endforeach
    </section>
@endsection
