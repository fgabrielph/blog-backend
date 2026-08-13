<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PostController extends Controller
{
    public function publicFeed(): AnonymousResourceCollection
    {
        return PostResource::collection(Post::with('user')->where('is_published', true)->latest()->paginate(request('limit', 5)));
    }
    
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(auth()->user()->posts()->with('user')->latest()->paginate(request('limit', 5)));
    }

    public function store(PostRequest $request): JsonResource
    {

        $data = auth()->user()->posts()->create($request->validated());

        return PostResource::make($data);
    }

    public function show(Post $post): JsonResource
    {
        return PostResource::make($post->load('user'));
    }

    public function update(UpdateRequest $request, Post $post): JsonResource
    {
        $post->update($request->validated());

        return PostResource::make($post);
    }

    public function destroy(Post $post): string
    {
        $post->delete();

        return 'Post Deleted';
    }
}
