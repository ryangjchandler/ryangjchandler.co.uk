@extends('layouts.app')

@section('content')
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Supporting Me</h2>
        <p class="md:text-lg mb-2 text-gray-700">No matter how big or small.</p>
    </section>
    <section class="mb-8 markup">
        <p>
            My main goal for 2020 is to build a community of followers who are interested in Laravel and JavaScript, as well as focus more on
            open source projects and quality content for this website.
        </p>
        <p>One way of helping me achieve this goal is by supporting my work through the following methods:</p>
        <ul class="list-disc mb-6">
            <li>
                <a href="{{ config('services.github.sponsors_link') }}"
                    target="_blank"
                    rel=”noopener noreferrer”
                >
                    GitHub Sponsors
                </a> &mdash; a monthly payment with reasonably priced tiers.
            </li>
            <li>
                <a href="{{ route('home') }}">
                    Newsletter
                </a> &mdash; a bi-weekly newsletter with new articles, videos and resources for Laravel and JavaScript devs.
            </li>
        </ul>
        <p>
            The more people that use these methods to support me, the more time and energy I can put into achieving my 2020 goal and helping others out.
        </p>
    </section>
@endsection
