@extends('layouts.master', ['title' => 'Articles'])

@section('body')
    @foreach($posts as $post)
        @include('partials.post-card', ['post' => $post])
    @endforeach
@endsection
