<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Cms\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::query()
            ->when($request->input('sortBy'), function (Builder $query) use ($request) {
                $query->orderBy($request->input('sortBy'), $request->input('sort') ?: 'desc');
            })
            ->when($request->input('status'), function (Builder $query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->get();

        return view('cms.posts.index', [
            'posts' => $posts,
            'sort' => $request->input('sort'),
            'sortBy' => $request->input('sortBy'),
            'status' => $request->input('status'),
            'statuses' => [
                'draft' => 'Draft',
                'published' => 'Published',
                'archived' => 'Archived',
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.posts.create', [
            'statuses' => [
                'draft' => 'Draft',
                'published' => 'Published',
                'archived' => 'Archived',
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
        ]);

        $post = Post::create($data);

        return redirect()->route('cms.posts.show', $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cms\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return redirect()->route('cms.posts.edit', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cms\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('cms.posts.edit', [
            'post' => $post,
            'statuses' => [
                'draft' => 'Draft',
                'published' => 'Published',
                'archived' => 'Archived',
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cms\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cms\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
