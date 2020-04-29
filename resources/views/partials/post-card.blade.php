@if($post->published || auth()->check())
    <div>
        <h2>
            <a href="{{ $post->url }}">{{ $post->title }}</a>
        </h2>
        <time datetime="{{ $post->published_at }}" style="margin-right: 10px;">
            📅 {{ $post->published_at->format('j, M Y') }}
        </time>
        <span>⏱ {{ $post->reading_time }}</span>
        <p>{!! $post->excerpt !!}</p>
    </div>
@endif
