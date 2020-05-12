@extends('layouts.app')

@section('content')
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">{{ random_greeting() }} I'm Ryan.</h2>
        <p class="md:text-lg mb-2 text-gray-700">I'm a web developer, wannabe writer and space geek based in Essex, United Kingdom.</p>
        <p class="md:text-lg text-gray-700">I currently work at <a href="https://surewise.com" class="text-primary-500 underline font-medium">Surewise</a> where I build and maintain insurance systems.</p>
    </section>
    <section class="mb-8">
        <x-newsletter-form />
    </section>
    <section>
        <h3 class="text-xl font-semibold mb-4">Articles</h3>
        <p class="mb-2 text-gray-700">I like to document my thoughts and processes, as well as teach new programming techniques and concepts.</p>
        @foreach($articles as $article)
            @include('partials.article-card', ['article' => $article])
        @endforeach
    </section>
@endsection
