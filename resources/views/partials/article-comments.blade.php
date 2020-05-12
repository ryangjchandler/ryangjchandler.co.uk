<details class="bg-primary-300 bg-opacity-50 px-4 py-2 rounded-b-lg">
    <summary class="font-semibold">View all comments</summary>
    @forelse($article->comments as $comment)
        <div class="my-4 pl-4 py-4 pr-6 bg-primary-300 bg-opacity-75 rounded-lg">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center text-primary-800  ">
                    <img src="{{ $comment->user->avatar() }}" alt="{{ $comment->user->name }}" class="rounded-full w-8 h-8 mr-4">
                    <span class="font-medium mr-1">{{ $comment->user->name }}</span> says...
                </div>
                <div class="flex items-center">
                    <time class="text-sm text-primary-800" datetime="{{ $comment->last_interaction_at->format('Y-m-d H:i:s') }}">
                        {{ $comment->last_interaction_at->diffForHumans() }}
                    </time>
                </div>
            </div>
            <div>
                {!! $comment->content !!}
            </div>
        </div>
    @empty
        <div class="my-4">
            There's nothing to see here.
        </div>
    @endforelse
</details>
