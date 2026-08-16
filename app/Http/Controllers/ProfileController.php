<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProfileController extends Controller
{
    public function __invoke()
    {

        return auth()->user();

    }

    public function comments(): AnonymousResourceCollection
    {
        return CommentResource::collection(
            auth()->user()->comments()->with('post')->latest()->paginate(request('limit', 5))
        );
    }
}
