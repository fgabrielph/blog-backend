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
    public function index(): AnonymousResourceCollection
    {
        return PostResource::collection(auth()->user()->posts()->get());
    }

    public function store(PostRequest $request): JsonResource
    {

        $data = auth()->user()->posts()->create($request->validated());

        return PostResource::make($data);
    }

    public function show(Post $post): JsonResource
    {
        return PostResource::make($post);
    }

    public function update(UpdateRequest $request, Post $post): JsonResource
    {
        $updated_data = $post->update($request->validated());

        return PostResource::make($updated_data);
    }

    public function destroy(Post $post): string
    {
        $post->delete();

        return 'Post Deleted';
    }
}
