<x-layouts.main title="{{ $post->title }}">
    <div class="flex items-center mb-4 space-x-1 text-sm font-semibold text-gray-600 uppercase">
        <span>Published </span>
        <time datetime="{{ $post->published_at->format('Y-m-d H:i:s') }}" class="text-gray-800">
            {{ $post->published_at->format('j M, Y') }}
        </time>
        @if ($post->category)
            <span>in </span>

            <x-pill :href="$post->category->url()" :color="$post->category->color">
                {{ $post->category->title }}
            </x-pill>
        @endif
    </div>

    <article class="prose-sm prose prose-indigo md:prose md:prose-indigo">
        <h1>{{ $post->title }}</h1>

        @markdown($post->content, 'post-content-'.$post->slug)
    </article>
</x-layouts.main>
