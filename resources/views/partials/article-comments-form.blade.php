<div class="my-4 pl-4 py-4 pr-6 bg-primary-300 border-b-2 border-primary-400 bg-opacity-50 rounded-t-lg">
    <div class="flex items-start">
        <div>
            <img src="{{ auth()->user()->avatar() }}" alt="{{ auth()->user()->name }}" class="hidden md:block rounded-full w-8 h-8 mr-4">
        </div>
        <div class="flex-1">
            <form action="{{ route('articles.comments.store', ['article' => $article]) }}" method="POST">
                @csrf
                <textarea class="form-textarea rounded-lg w-full resize-none mb-2" name="content" id="content"
                    placeholder="You **can** use Markdown inside of _here_..." rows="5"></textarea>
                @error('content')
                    <span class="text-red-700">{{ $message }}</span>
                @enderror
                <button type="submit"
                    class="w-full md:w-1/4 px-4 py-2 border-2 border-primary-500 rounded-lg font-semibold text-primary-500"
                >
                    Post
                </button>
            </form>
        </div>
    </div>
</div>
