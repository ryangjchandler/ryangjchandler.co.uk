@extends('layouts.master', ['title' => $post->title])

@section('body')
    <article>
        <h2>{{ $post->title }}</h2>
        <time datetime="{{ $post->published_at }}" style="margin-right: 10px;">
            📅 {{ $post->published_at->format('j, M Y') }}
        </time>
        <span>⏱ {{ $post->reading_time }}</span>
        {!! $post->parsed_content !!}
    </article>
@endsection
