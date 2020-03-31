@extends('_layouts.master')

@section('title', $page->title . ' - Ryan Chandler')

@section('body')
    <section class="markup">
        <h1 class="leading-normal">{{ $page->title }}</h1>
        <p class="text-sm -mt-2 text-gray-700 hover:text-gray-900 leading-normal">
            @yield('content')
        </p>
    </section>
@endsection