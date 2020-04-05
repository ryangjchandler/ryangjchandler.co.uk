<div class="flex flex-col mb-8">
    <h2 class="font-semibold text-lg md:text-xl mb-3">
        <a href="{{ $post->getUrl() }}">{{ $post->title }}</a>
    </h2>
    <div class="flex items-center mb-4">
        <time datetime="{{ date('Y-m-d', $post->date) }}" class="text-gray-700 text-sm md:text-base mr-4">📅 {{ date('d, M Y', $post->date) }}</time>
        <p class="text-gray-700 text-sm md:text-base">⏱ {{ $post->readingTime() }}</p>
    </div>
    <p class="mb-4">{{ $post->excerpt(150) }}</p>
    @include('partials::_categories')
</div>