@extends('_layouts.master')

@section('title', 'Articles - Ryan Chandler')

@section('body')
    <section class="post-header">
        <h1 class="leading-normal mb-5">{{ $page->title }}</h1>
        <hr class="mb-5" />
        @foreach($posts as $post)
            @include('_partials._post-card', ['post' => $post])

            @if(! $loop->last) 
                <hr class="mb-8" />
            @endif
        @endforeach
    </section>
@endsection