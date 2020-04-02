<div id="post-archived" class="bg-orange-100 border border-orange-500 text-orange-700 px-4 py-3 rounded relative" role="alert">
    @if($post->archived_date)
        <strong>Warning!</strong>
        <span class="block sm:inline">
            This article was archived on {{ carbon($post->archived_date)->format('d, M Y') }} and is no longer being updated.
            @if($post->archived_alternative)
                An alternative has been suggested, <a href="{{ $post->archived_alternative" target="_blank" rel="noopener noreferrer" class="underline">click here to go there now.</a>
            @endif
        </span>
    @else
        <strong>Warning!</strong>
        <span class="block sm:inline">
            This article has been archived and is no longer being updated.
            @if($post->archived_alternative)
                An alternative has been suggested, <a href="{{ $post->archived_alternative" target="_blank" rel="noopener noreferrer" class="underline">click here to go there now.</a>
            @endif
        </span>
    @endif
</div>