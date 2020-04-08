<div id="pagination" class="flex justify-between">
    <h1 class="hidden">Previous and Next Article Navigation</h1>

    @if($previous = $post->getPrevious())
        <div class="w-1/2 pr-2">
            <a href="{{ $previous->getUrl() }}" class="underline text-sm font-semibold dark:text-gray-300" title="{{ $previous->title }}">← {{ $previous->title }}</a>
        </div>
    @endif

    @if($next = $post->getNext())
        <div class="@if($previous) w-1/2 pl-2 @else w-full @endif text-right">
            <a href="{{ $next->getUrl() }}" class="underline text-sm font-semibold dark:text-gray-300" title="{{ $next->title }}">→ {{ $next->title }}</a>
        </div>
    @endif
</div>