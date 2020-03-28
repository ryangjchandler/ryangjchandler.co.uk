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
                    <a href="#" class="underline" style="text-decoration-color: #718096;">Twitter</a>, <a href="#"  class="underline" style="text-decoration-color: #718096;">GitHub</a>
                </li>
            </ul>
        </section>
        <section class="pl-4">
            <h2 class="text-lg text-gray-700 mb-8">Articles</h2>
            <table class="w-full">
                <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td class="p-0 align-middles">
                            <a href="{{ $post->getUrl() }}" class="underline" style="text-decoration-color: #718096;">{{ $post->title }}</a>
                        </td>
                        <td class="text-right align-middle">
                            {{ date('j, M Y', $post->date) }}
                        </td>
                    </tr>
                @empty
                    <p>🤦🏻‍♂️ Don't worry, something will be here soon!</p>
                @endforelse
                </tbody>
            </table>
        </section>
    </main>

@endsection
