@extends('layouts.master', ['title' => $category->title])

@section('body')
    @foreach($categories as $category)
        @include('partials.category-card', ['category' => $category])
    @endforeach
@endsection
