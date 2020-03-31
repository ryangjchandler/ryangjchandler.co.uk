@extends('_layouts.master')

@section('title', 'Categories - Ryan Chandler')

@section('body')
    <main class="markup">
        <h1>Categories</h1>
        <ul>
            @foreach($categories as $category)
                <li>
                    <a href="#">{{ $category->title }}</a>
                </li>
            @endforeach
        </ul>
    </main>
@endsection