<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function getOrderList() {
        $orders = Order::query()->with([
            'user',
            'products'
        ])->where('type', 'Заказ')->where('user_id', auth()->user()->id)->get();

        return response()->json([
            'status' => true,
            'orders' => OrderResource::collection($orders)
        ]);
    }

//    public function getOrder($id) {
//        $order = Order::query()->findOrFail($id);
//        return response()->json([
//            'status'=> true,
//            'order'=> OrderResource::make($order)
//        ])->setStatusCode(200);
//    }
//
//    public function craeteOrder(OrderRequest $request) {
//        $data = $request->validated();
//        $order = new Order();
//        $order->user = $data['user'];
//        $order->product = $data['product'];
//        $order->count = $data['count'];
//        $order->save();
//        return response()->json([
//            'status' => true
//        ]);
//    }
//
//    public function deleteOrder($id) {
//        $order = Order::query()->findOrFail($id);
//
//        $order->deleteOrFail();
//
//        return response()->json([
//            'status' => true,
//            'messages' => 'Order deletes successfully'
//        ]);
//    }
}
