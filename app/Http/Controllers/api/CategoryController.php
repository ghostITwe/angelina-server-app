<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function getCategoryList()
    {
        $categories = Category::query()->with([
            'products',
        ])->get();

        return response()->json([
            'status' => true,
            'categories' => CategoryResource::collection($categories)
        ]);

    }

    public function getCategory($title)
    {
        $category = Category::query()->with([
            'products',
        ])->where('title', $title)->firstOrFail();

        return response()->json([
            'status' => true,
            'category' => CategoryResource::make($category)
        ])->setStatusCode(200);
    }

    public function createCategory(CreateCategoryRequest $request)
    {
        $data = $request->validated();

        $category = new Category();
        $category->title = $data['title'];
        $category->image = Storage::disk('public')->put('categories', $request->file('image'));
        $category->save();

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function deleteCategory($id)
    {
        $category = Category::query()->with([
            'products',
        ])->findOrFail($id);

        $category->deleteOrFail();

        return response()->json([
           'status' => true,
           'message' => 'Category deleted successfully'
        ]);
    }
}
