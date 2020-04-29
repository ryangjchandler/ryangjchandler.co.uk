@extends('layouts.master', ['title' => $category->title])

@section('body')
    <main>
        <h2>{{ $category->title }}</h2>
        <p>{!! $category->parsed_content !!}</p>

        @foreach($category->posts as $post)
            @include('partials.post-card', ['post' => $post])
        @endforeach
    </main>
@endsection
