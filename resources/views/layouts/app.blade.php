@extends('layouts.master')

@section('body')
    @include('layouts.partials.header')

    <main class="max-w-4xl container px-4 mx-auto pt-8 md:pt-24 pb-8">
        @yield('content')
    </main>
@endsection
