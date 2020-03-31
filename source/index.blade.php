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
                    <a href="https://twitter.com/ryangjchandler" target="_blank" class="underline" style="text-decoration-color: #718096;">Twitter</a>, <a href="https://github.com/ryangjchandler" target="_blank" class="underline" style="text-decoration-color: #718096;">GitHub</a>
                </li>
            </ul>
        </section>
        <section class="mb-8 md:mb-16">
            <h2 class="text-lg text-gray-700 mb-8">About Me</h2>
            <p class="leading-loose mb-4">
                I'm 19 years old and currently working as a Full Stack Web Developer at <a href="https://surewise.com" class="underline">Surewise</a>.
                I primarily work with Laravel, with no specific front-end framework. 
            </p>
            <p class="leading-loose">
                I try my best to contribute to open source projects. I'm quite heavily involved in the development and repository maintenance of
                <a href="https://github.com/alpinejs" target="_blank" class="underline">Alpine.js</a>, which is a lightweight Vue / React alternative for small to medium sized JavaScript components.
                I have also contributed to other open source projects but you can find my contribution graph on <a href="https://github.com/ryangjchandler" target="_blank" class="underline">GitHub</a>.
            </p>
        </section>
        <section>
            <h2 class="text-lg text-gray-700 mb-8">Articles</h2>
            @forelse($posts->take(3) as $post) 
                @include('_partials._post-card')

                @if(! $loop->last)
                    <hr class="mb-8">
                @endif
            @empty
                <p>🤦🏻‍♂️ Don't worry, something will be here soon!</p>
            @endforelse
        </section>
    </main>

@endsection
