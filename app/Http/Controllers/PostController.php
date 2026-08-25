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
        return PostResource::collection(Post::with(['user', 'category'])->where('is_published', true)->latest()->paginate(request('limit', 5)));
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
        abort_unless($post->is_published || auth('sanctum')->id() === $post->user_id, 404);

        return PostResource::make($post->load(['user', 'category']));
    }

    public function update(UpdateRequest $request, Post $post): JsonResource
    {
        abort_unless(auth()->id() === $post->user_id, 403);

        $post->update($request->validated());

        return PostResource::make($post);
    }

    public function destroy(Post $post): string
    {
        abort_unless(auth()->id() === $post->user_id, 403);

        $post->delete();

        return 'Post Deleted';
    }
}
