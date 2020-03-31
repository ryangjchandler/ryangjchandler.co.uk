@extends('_layouts.master')

@section('title', 'Categories - Ryan Chandler')

@section('body')
    <main class="markup">
        <h1>Categories</h1>
        @foreach($categories as $category)
            <div>
                <h2 class="mb-4">
                    <a href="#">{{ $category->title }}</a>
                </h2>
                {!! $category->getContent() !!}
            </div>
        @endforeach
    </main>
@endsection