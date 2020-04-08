@extends('layouts::master')

@section('title', 'Categories - Ryan Chandler')

@section('body')
    <main class="markup">
        <h1 class="dark:text-gray-200">Categories</h1>
        @foreach($categories as $category)
            <div>
                <h2 class="mb-4 no-markup">
                    <a href="{{ $category->getUrl() }}" class="dark:text-gray-300 permalink ml-0">{{ $category->title }}</a>
                </h2>
                <div class="dark:text-gray-400">
                    {!! $category->getContent() !!}
                </div>
            </div>
        @endforeach
    </main>
@endsection