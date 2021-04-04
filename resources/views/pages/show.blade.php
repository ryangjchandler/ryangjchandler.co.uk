<x-layouts.main title="{{ $page->title }}">
    <article class="prose-sm prose prose-indigo md:prose md:prose-indigo">
        <h1>{{ $page->title }}</h1>

        @markdown($page->content, 'page-content-'.$page->slug)
    </article>
</x-layouts.main>
