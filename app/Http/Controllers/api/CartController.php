<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class cartController extends Controller
{
    //
    public function addCart (CartRequest $request) {
        $data = $request->validated();
        $product = Product::query()->findOrFail($request['product_id']);
        if($cart = Cart::where(['user_id' => $data['user'],'product_id' => $product->id])->first()){
            $cart = Cart::create([
                'user_id' => $data['user'],
                'product_id' => $data['product_id']
            ]);
            $cart->save();
            return response()->json([
                'status' => true
            ]);
        } else{
            return response()->json([
                'status' => false,
                'error' => 'This item is exist'
            ]);
        }

        // Какую ошибку вы вывести тут
    }
    public function getCart($user_id) {

        return Cart::query()->with(['products'])->findOrFail(['user_id' => $user_id]);
    }
    public function deleteProduct(CartRequest $request) {
        $data = $request->validated();
        if(Cart::query()->where(['user_id' => $request['user_id'],'product_id' => $request['product_id']])->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Product deleted successfully from cart'
            ]);
        }
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => 'Current product didn`t find'
        ], 422));
    }
}
