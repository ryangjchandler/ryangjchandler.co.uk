<div class="flex flex-col mb-8">
    <time datetime="{{ date('Y-m-d', $post->date) }}" class="text-gray-700 text-sm md:text-base mb-3">{{ date('j, M Y', $post->date) }}</time>
    <h2 class="font-semibold md:text-lg mb-4">
        <a href="{{ $post->getUrl() }}">{{ $post->title }}</a>
    </h2>
    @include('_partials._categories')
</div>