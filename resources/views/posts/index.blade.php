<x-layouts.main title="Blog">
    <section>
        @foreach($posts as $post)
            <article class="space-y-4 {{ $loop->last ? 'mb-16' : null }}">
                <time
                    datetime="{{ $post->published_at->format('Y-m-d H:i:s') }}"
                    class="text-sm font-semibold text-gray-600 uppercase"
                >
                    {{ $post->published_at->format('j M, Y') }}
                </time>

                <div class="space-y-4">
                    <a href="{{ route('posts.show', $post) }}" class="block text-2xl font-bold">
                        {{ $post->title }}
                    </a>

                    <div class="prose">
                        @markdown($post->excerpt, 'post-excerpt-' . $post->getKey())
                    </div>

                    <a href="{{ route('posts.show', $post) }}" class="block font-medium text-indigo-600 focus:underline hover:underline">
                        Read more
                    </a>
                </div>
            </article>

            @if(! $loop->last)
                <hr class="my-8">
            @endif
        @endforeach
    </section>

    <section>
        {{ $posts->links() }}
    </section>
</x-layouts.main>
