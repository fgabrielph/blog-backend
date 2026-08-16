<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Category::query();

        if ($request->boolean('has_posts')) {
            $query->whereHas('posts', function ($q) {
                $q->where('is_published', true);
            });
        }

        $query->withCount(['posts' => function ($q) {
            $q->where('is_published', true);
        }]);

        $categories = $query->latest()->take(10)->get();

        return CategoryResource::collection($categories);
        // return CategoryResource::collection(Category::all());
    }

    public function store(CategoryRequest $request): JsonResource
    {
        $data = auth()->user()->posts()->create($request->validated());

        return CategoryResource::make($data);
    }

    public function show(Category $category): AnonymousResourceCollection
    {
        return PostResource::collection(
            $category->posts()->with(['user', 'category'])->where('is_published', true)->latest()->paginate(10)
        );
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Category $category): string
    {
        $category->delete();

        return 'Category Deleted';
    }
}
