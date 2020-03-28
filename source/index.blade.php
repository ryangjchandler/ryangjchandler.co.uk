@extends('_layouts.master')

@section('body')

    <main>
        <section class="mb-8 md:mb-16">
            <ul>
                <li class="pl-4 mb-2">
                    <span class="mr-2">🗺</span>
                    Essex, United Kingdom
                </li>
                <li class="pl-4 mb-2">
                    <span class="mr-2">📧</span>
                    <a href="mailto:contact@ryangjchandler.co.uk" class="underline" style="text-decoration-color: #718096;">contact@ryangjchandler.co.uk</a>
                </li>
                <li class="pl-4">
                    <span class="mr-2">🔗</span>
                    <a href="#" class="underline" style="text-decoration-color: #718096;">Twitter</a>, <a href="#"  class="underline" style="text-decoration-color: #718096;">GitHub</a>
                </li>
            </ul>
        </section>
        <section class="pl-4">
            <h2 class="text-lg text-gray-700 mb-8">Articles</h2>
            <table class="w-full">
                <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td class="p-0 align-middles">
                            <a href="{{ $post->getUrl() }}" class="underline" style="text-decoration-color: #718096;">{{ $post->title }}</a>
                        </td>
                        <td class="text-right align-middle">
                            {{ date('j, M Y', $post->date) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </section>
    </main>

@endsection
