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

    <hr>

    <section>
        <table>
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="55%">Title</th>
                    <th width="10%">Status</th>
                    <th width="20%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ ucfirst($post->status) }}</td>
                        <td>
                            <a href="{{ route('cms.posts.edit', $post) }}">
                                Edit
                            </a>
                            <form action="{{ route('cms.posts.destroy', $post) }}" method="POST" style="display: inline;">
                                @method('DELETE')
                                @csrf
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</x-cms-layout>
