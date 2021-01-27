<x-cms-layout title="Posts">
    <button x-data @click="window.location = route('cms.posts.create')">New Post</button>

    <hr>

    <form action="{{ route('cms.posts.index') }}" method="GET">
        <fieldset>
            <legend>Filters</legend>

            <div style="display: flex; align-items: center;">
                <select name="sort" id="sort" style="margin-right: 10px">
                    <option value="" selected>Sort</option>
                    <option value="asc" {{ $sort === 'asc' ? 'selected' : null }}>Ascending</option>
                    <option value="desc" {{ $sortBy === 'desc' ? 'selected' : null }}>Descending</option>
                </select>
                <select name="sortBy" id="sortBy" style="margin-right: 10px;">
                    <option value="" selected>Sort by</option>
                    <option value="id" {{ $sortBy === 'id' ? 'selected' : null }}>ID</option>
                    <option value="title" {{ $sortBy === 'title' ? 'selected' : null }}>Title</option>
                    <option value="status" {{ $sortBy === 'status' ? 'selected' : null }}>Status</option>
                </select>
                <select name="status" id="status" style="margin-right: 10px">
                    <option value="" selected>Status</option>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" {{ $status === $value ? 'selected' : null }}>{{ $label }}</option>
                    @endforeach
                </select>
                <input type="submit" value="Apply filters">
            </div>
        </fieldset>
    </form>
</x-cms-layout>
