<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $currentCart;

    public function getCart() {
        $this->currentCart = Order::query()
            ->with([
                'user',
                'products'
            ])
            ->where('type', 'Корзина')
            ->where('user_id', auth()->user()->id)->first();

        if (empty($this->currentCart)) {
            return response()->json([
                'status' => false,
                'message' => 'Cart empty, please add items'
            ]);
        }

        return response()->json([
            'status' => true,
            'cart' => CartResource::make($this->currentCart)
        ]);
    }

    public function cartConfirm()
    {
        $currentCart = Order::query()
            ->with([
                'user',
                'products'
            ])
            ->where('type', 'Корзина')
            ->where('user_id', auth()->user()->id)->first();

        $currentCart->type = 'Заказ';
        $currentCart->save();

        return response()->json([
            'status' => true,
            'message' => 'Cart to Order confirmed'
        ]);
    }

    public function addItem($id)
    {
        $currentCart = Order::query()
            ->with([
                'user',
                'products'
            ])
            ->where('type', 'Корзина')
            ->where('user_id', auth()->user()->id)->first();

        if (empty($currentCart)) {
            $currentCart = Order::create([
                'user_id' => auth()->user()->getKey()
            ]);
        }

        if ($currentCart->products->contains($id)) {
            $cartItem = $currentCart->products()->where('product_id', $id)->first()->pivot;
            $cartItem->quantity++;
            $cartItem->update();
        } else {
            $newItem = Product::query()->findOrFail($id);
            $currentCart->products()->attach($id, ['quantity' => 1, 'cost' => $newItem->price]);
        }

        return response()->json([
           'status' => true,
           'message' => 'Item added to cart',
           'cart' => $currentCart
        ]);
    }

    public function deleteItem($id)
    {
        $currentCart = Order::query()
            ->with([
                'user',
                'products'
            ])
            ->where('type', 'Корзина')
            ->where('user_id', auth()->user()->id)->first();


    }
}
