<x-layouts.main title="{{ $post->title }}">
    <article class="prose-sm prose prose-indigo md:prose md:prose-indigo">
        <time
            datetime="{{ $post->published_at->format('Y-m-d H:i:s') }}"
            class="inline-block mb-4 text-sm font-semibold text-gray-600 uppercase"
        >
            {{ $post->published_at->format('j M, Y') }}
        </time>

        <h1>{{ $post->title }}</h1>

        @markdown($post->content, 'post-content-'.$post->slug)
    </article>
</x-layouts.main>
