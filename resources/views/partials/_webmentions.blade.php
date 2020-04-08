<details>
    <summary class="dark:text-gray-300">Webmentions</summary>
    <div class="pt-8">
        @forelse($page->webmentions() as $webmention)
            <div class="mb-4">
                <div class="flex items-center mb-4">
                    <img src="{{ $webmention->avatar() }}" alt="{{ $webmention->author->name}} Avatar" class="w-10 h-10 rounded-full mr-4">
                    <div class="flex flex-col md:flex-row">
                        <strong class="mr-4 tracking-wide mb-1 md:mb-0 dark:text-gray-400">
                            <a href="{{ $webmention->author->url }}" target="_blank" rel="noopener noreferrer" class="underline">{{ $webmention->author->name }}</a>
                            <a href="{{ $webmention->sourceUrl }}" target="_blank" rel="noopener noreferrer" class="underline">{{ $webmention->keyword }}</a>
                        </strong>
                        <time datetime="{{ $webmention->date->format('Y-m-d') }}" class="text-gray-600">{{ $webmention->date->format('d, M Y') }}</time>
                    </div>
                </div>
                @if($webmention->type !== 'repost-of')
                    <div class="dark:text-gray-400">
                        {!! $webmention->content !!}
                    </div>
                @endif
            </div>
            @if(! $loop->last)
                <hr class="mb-4" />
            @endif
        @empty
            <div class="mb-4 dark:text-gray-400">
                😞 There's no webmentions here yet.
            </div>
        @endforelse
    </div>
</details>