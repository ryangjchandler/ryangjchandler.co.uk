@extends('_layouts.master')

@section('title', 'Ryan Chandler')

@section('body')

    <main>
        <section class="mb-8 md:mb-16">
            <ul>
                <li class="mb-2">
                    <span class="mr-2">🗺</span>
                    Essex, United Kingdom
                </li>
                <li class="mb-2">
                    <span class="mr-2">📧</span>
                    <a href="mailto:contact@ryangjchandler.co.uk" class="underline" style="text-decoration-color: #718096;">contact@ryangjchandler.co.uk</a>
                </li>
                <li class="">
                    <span class="mr-2">🔗</span>
                    <a href="https://twitter.com/ryangjchandler" class="underline" style="text-decoration-color: #718096;">Twitter</a>, <a href="https://github.com/ryangjchandler"  class="underline" style="text-decoration-color: #718096;">GitHub</a>
                </li>
            </ul>
        </section>
        <section>
            <h2 class="text-lg text-gray-700 mb-8">Articles</h2>
            @forelse($posts as $post) 
                <div class="flex flex-col mb-8">
                    <time datetime="{{ date('Y-m-d', $post->date) }}" class="text-gray-700 text-sm md:text-base mb-3">{{ date('j, M Y', $post->date) }}</time>
                    <h2 class="font-semibold md:text-lg mb-4">
                        <a href="{{ $post->getUrl() }}">{{ $post->title }}</a>
                    </h2>
                    @include('_partials._categories')
                </div>
            @empty
                <p>🤦🏻‍♂️ Don't worry, something will be here soon!</p>
            @endforelse
        </section>
    </main>

@endsection
