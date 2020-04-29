@extends('layouts.master', ['title' => 'Categories'])

@section('body')
    @foreach($categories as $category)
        @include('partials.category-card', ['category' => $category])
    @endforeach
@endsection
