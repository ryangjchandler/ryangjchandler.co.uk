<ul class="flex items-center list-none">
    @foreach($post->categories ?? [] as $category)
        <li class="mr-4 bg-indigo-200 text-xs px-4 py-1 rounded-full text-indigo-900 font-semibold leading-normal">
            <a href="/categories/{{ $category }}">{{ $category }}</a>
        </li>
    @endforeach
</ul>