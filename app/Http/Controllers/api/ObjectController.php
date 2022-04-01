<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObjectsResource;
use App\Models\Post;
use Illuminate\Http\Request;

class ObjectController extends Controller
{
    public function getObjects()
    {
        $objects = Post::query()->with([
            'category',
            'pictures',
            'information'
        ])->get();

        return response()->json([
            'status' => true,
            'objects ' => ObjectsResource::collection($objects)
        ])->setStatusCode(200);
    }

    public function getObject($id)
    {

    }
}
