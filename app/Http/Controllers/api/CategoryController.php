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
            'image'
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
            'image'
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

        $image = new Image();
        $image->path = Storage::disk('public')->put('categories', $request->file('image'));
        $image->save();

        $category->image_id = $image->id;
        $category->save();

        return response()->json([
            'status' => true
        ]);
    }

    public function deleteCategory($id)
    {
        $category = Category::query()->with([
            'products',
            'image'
        ])->findOrFail($id);

        $category->deleteOrFail();

        return response()->json([
           'status' => true,
           'message' => 'Category delete'
        ]);
    }
}
