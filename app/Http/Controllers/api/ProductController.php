<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\CreateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function getProduct($id)
    {
        $product = Product::query()->with([
            'category',
            'images'
        ])->findOrFail($id);


        return response()->json([
            'status' => true,
            'products' => ProductResource::make($product)
        ]);
    }

    public function getProducts()
    {
        $products = Product::query()->with([
            'category',
            'images'
        ])->get();


        return response()->json([
            'status' => true,
            'products' => ProductResource::collection($products)
        ]);
    }

    public function createProduct(CreateProductRequest $request)
    {
        $data = $request->validated();

        $category = Category::query()->where('title', $data['category'])->firstOrFail();

        $product = new Product();
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->category_id = $category->id;
        $product->save();

        foreach ($request->file('images') as $image) {
            $product->images()->create([
                'product_id' => $product->id,
                'path' => $image->store('products', 'public')
            ]);
        }

        return response()->json([
            'status' => true
        ]);
    }

    /**
     * @throws \Throwable
     */
    public function deleteProduct($id)
    {
        $product = Product::query()->with([
            'category',
            'images'
        ])->findOrFail($id);

        $product->deleteOrFail();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}
