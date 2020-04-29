@if($category->has_archive || auth()->check())
    <div>
        <h2>
            <a href="{{ $category->url }}">{{ $category->title }}</a>
        </h2>
        <p>{!! $category->parsed_content !!}</p>
    </div>
@endif
