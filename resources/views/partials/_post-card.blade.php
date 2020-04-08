<div class="flex flex-col mb-8">
    <h2 class="font-semibold dark:text-gray-300 text-lg md:text-xl mb-3">
        <a href="{{ $post->getUrl() }}">{{ $post->title }}</a>
    </h2>
    <div class="flex items-center mb-4">
        <time datetime="{{ date('Y-m-d', $post->date) }}" class="dark:text-gray-400 text-gray-700 text-sm md:text-base mr-4">📅 {{ date('d, M Y', $post->date) }}</time>
        <p class="dark:text-gray-400 text-gray-700 text-sm md:text-base">⏱ {{ $post->readingTime() }}</p>
    </div>
    <p class="mb-4 dark:text-gray-500">{{ $post->excerpt(150) }}</p>
    @include('partials::_categories')
</div>
