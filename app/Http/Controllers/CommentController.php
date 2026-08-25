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
        $limit = request('limit', 5);
        $query = $post->comments()->with('user')->latest('id');

        $commentId = request('comment_id');
        $targetPage = null;

        if ($commentId) {
            $position = (clone $query)->pluck('id')->values()->search((int) $commentId);

            if ($position !== false) {
                $targetPage = (int) ceil(($position + 1) / $limit);
            }
        }

        $paginator = $query->paginate($limit);

        $response = CommentResource::collection($paginator);

        if ($targetPage !== null) {
            $response->additional(['target_comment_page' => $targetPage]);
        }

        return $response;
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
        abort_unless(auth()->id() === $comment->user_id, 403);

        $updated_data = $comment->update($request->validated());

        return CommentResource::make($updated_data);
    }

    public function destroy(Post $post, Comment $comment): string
    {
        abort_unless(auth()->id() === $comment->user_id, 403);

        $comment->delete();

        return 'Comment Deleted';
    }
}
