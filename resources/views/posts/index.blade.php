<x-layouts.main title="Blog">
    <section>
        @isset($category)
            <div class="flex items-center justify-between mb-8 md:mb-16">
                <h1 class="block text-2xl font-bold">{{ $category->title }}</h1>

                <p class="text-sm font-medium text-gray-400 uppercase">Showing {{ $posts->count() }} posts</p>
            </div>
        @endisset

        @foreach($posts as $post)
            <article class="space-y-4 {{ $loop->last ? 'mb-16' : null }}">
                <div class="flex items-center space-x-1 text-sm font-semibold text-gray-600 uppercase">
                    <span>Published </span>
                    <time
                        datetime="{{ $post->published_at->format('Y-m-d H:i:s') }}"
                        class="text-gray-800"
                    >
                        {{ $post->published_at->format('j M, Y') }}
                    </time>
                    @if($post->category)
                        <span>in </span>

                        <x-pill :href="$post->category->url()" :color="$post->category->color">
                            {{ $post->category->title }}
                        </x-pill>
                    @endif
                </div>

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
