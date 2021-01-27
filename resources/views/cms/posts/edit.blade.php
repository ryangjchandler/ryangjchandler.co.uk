<x-cms-layout title="Edit Post">
    <form action="{{ route('cms.posts.update', $post) }}" method="POST">
        @method('PUT')
        @csrf

        <h3>Edit Post</h3>

        <fieldset>
            <legend>Basic Details</legend>

            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}">

            @error('title')
                <strong>{{ $message }}</strong>
            @enderror

            <label for="slug">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ $post->slug }}" readonly>

            <label for="content">Content</label>
            <textarea cols="30" rows="20" name="content" id="content">{{ old('content', $post->content) }}</textarea>

            @error('content')
                <strong>{{ $message }}</strong>
            @enderror


            <label for="excerpt">Excerpt</label>
            <textarea cols="30" rows="20" name="excerpt" id="excerpt">{{ old('excerpt', $post->excerpt) }}</textarea>

            @error('excerpt')
                <strong>{{ $message }}</strong>
            @enderror

            <label for="status">Status</label>
            <select name="status" id="status">
                @foreach($statuses as $status => $label)
                    <option value="{{ $status }}" {{ old('status', $post->status) === $status ? 'selected' : null }}>{{ $label }}</option>
                @endforeach
            </select>

            @error('status')
                <strong>{{ $message }}</strong>
            @enderror

            <label for="publish_at">Publish at</label>
            <input type="datetime-local" name="publish_at" id="publish_at" value="{{ old('publish_at', optional($post->publish_at)->format('Y-m-d\TH:i')) }}">

            @error('publish_at')
                <strong>{{ $message }}</strong>
            @enderror

            <input type="submit" value="Save">
        </fieldset>
    </form>
</x-cms-layout>
