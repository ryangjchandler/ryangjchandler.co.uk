<article class="{{ ! $loop->first ? 'mt-4' : '' }}">
    <h3 class="text-primary-600 text-lg font-semibold mb-2">
        <a href="{{ route('articles.show', $article) }}" class="hover:underline">{{ $article->title }}</a>
    </h3>
    @if($article->excerpt)
        <p class="text-gray-900 mb-2">{{ $article->excerpt }}</p>
    @endif
    @if($article->published_at)
        <small class="text-gray-600 font-medium">Published {{ $article->published_at->diffForHumans() }}</small>
        @if($article->updated_at->gt($article->published_at))
            <span class="mx-2 text-gray-400">|</span>
            <small class="text-gray-600 font-medium">Updated {{ $article->updated_at->diffForHumans() }}</small>
        @endif
    @endif
    @if($article->sponsors_only)
        <small class="mx-2 text-gray-400">|</small>
        <small class="bg-primary-200 text-primary-900 font-bold rounded px-2 py-1">Sponsors only</small>
    @endif
</article>
