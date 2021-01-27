<x-cms-layout :title="$post->title">
    <button x-data @click="window.location = route('cms.posts.edit', {{ $post->id }})">Edit Post</button>
    <section>
        <h2>{{ $post->title }}</h2>

        @if($post->excerpt)
            <section>
                <h3>Excerpt</h3>
                <p>{{ $post->excerpt }}</p>
            </section>
        @endif

        @if($post->content)
            <section>
                <h3>Post</h3>
                <p>{{ $post->content }}</p>
            </section>
        @endif
    </section>
</x-cms-layout>
