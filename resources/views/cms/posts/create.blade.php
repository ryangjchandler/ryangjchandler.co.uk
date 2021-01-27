<x-cms-layout title="New Post">
    <form action="{{ route('cms.posts.store') }}" method="POST">
        @csrf

        <h3>New Post</h3>

        <fieldset>
            <legend>Basic Details</legend>

            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}">

            @error('title')
                <strong>{{ $message }}</strong>
            @enderror

            <label for="content">Content</label>
            <textarea cols="30" rows="20" name="content" id="content">{{ old('content') }}</textarea>

            @error('content')
                <strong>{{ $message }}</strong>
            @enderror


            <label for="excerpt">Excerpt</label>
            <textarea cols="30" rows="20" name="excerpt" id="excerpt">{{ old('excerpt') }}</textarea>

            @error('excerpt')
                <strong>{{ $message }}</strong>
            @enderror

            <label for="status">Status</label>
            <select name="status" id="status">
                @foreach($statuses as $status => $label)
                    <option value="{{ $status }}" {{ old('status') === $status ? 'selected' : null }}>{{ $label }}</option>
                @endforeach
            </select>

            @error('status')
                <strong>{{ $message }}</strong>
            @enderror

            <input type="submit" value="Create">
            <input type="reset" value="Reset">
        </fieldset>
    </form>
</x-cms-layout>
