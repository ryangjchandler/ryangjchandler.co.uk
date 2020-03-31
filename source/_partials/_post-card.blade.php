<div class="flex flex-col mb-8">
    <h2 class="font-semibold md:text-lg mb-3">
        <a href="{{ $post->getUrl() }}">{{ $post->title }}</a>
    </h2>
    <time datetime="{{ date('Y-m-d', $post->date) }}" class="text-gray-700 text-sm md:text-base mb-4">{{ date('j, M Y', $post->date) }}</time>
    <p class="mb-4">{{ $post->excerpt(150) }}</p>
    @include('_partials._categories')
</div>