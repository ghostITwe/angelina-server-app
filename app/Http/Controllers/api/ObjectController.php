<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ObjectsResource;
use App\Http\Resources\PictureCollection;
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

//        foreach ($objects as $object) {
//            foreach ($object->pictures as $picture) {
//                $object->pic = [
//                    $picture->picture
//                ];
//            }
//        }

        return response([
            'status' => true,
            'objects' => ObjectsResource::collection($objects)
        ])->setStatusCode(200);
    }

    public function getObject($id)
    {

    }
}
