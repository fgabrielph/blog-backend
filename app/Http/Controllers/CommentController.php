<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentController extends Controller
{
    public function index(Post $post): AnonymousResourceCollection
    {
        return CommentResource::collection($post->comments()->with('user')->get());
    }

    public function store(CommentRequest $request, Post $post): JsonResource
    {

        $data = $post->comments()->create([...$request->validated(), 'user_id' => auth()->user()->id]);

        return CommentResource::make($data);
    }

    public function show(Post $post, Comment $comment): JsonResource
    {
        return CommentResource::make($comment->load('user'));
    }

    public function update(CommentRequest $request, Post $post, Comment $comment): JsonResource
    {
        $updated_data = $comment->update($request->validated());

        return CommentResource::make($updated_data);
    }

    public function destroy(Post $post, Comment $comment): string
    {
        $comment->delete();

        return 'Comment Deleted';
    }
}
