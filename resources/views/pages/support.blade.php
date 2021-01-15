@extends('layouts.app')

@section('content')
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Supporting Me</h2>
        <p class="md:text-lg mb-2 text-gray-700">No matter how big or small.</p>
    </section>
    <section class="mb-8 markup">
        <p>
            At some point in the future I'd love to spend most, if not all, of my time working on open-source projects and free content for this site.
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
                </a> &mdash; an occasional ewsletter with new articles, videos and resources for all developers.
            </li>
        </ul>
        <p>
            The more support I get from you, my fellow developers, the more time I can spend on making your life easier!
        </p>
    </section>
    <section class="mb-8">
        <h2 class="text-xl font-medium mb-4">Community Sponsors</h2>
        <p class="text-gray-700 mb-8">Your support allows me to spend more time on my open-source work and blog posts.</p>

        <div class="grid grid-cols-2 gap-8">
            @foreach($community as $sponsor)
                <div class="flex items-center space-x-6">
                    <img src="{{ $sponsor->avatar }}" alt="{{ $sponsor->username }}" class="w-16 h-16 rounded shadow">
                    <div>
                        <a href="{{ $sponsor->url }}" class="font-medium block hover:underline">{{ $sponsor->username }}</a>
                        <small>since {{ $sponsor->created_at->format('M Y') }}</small>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
