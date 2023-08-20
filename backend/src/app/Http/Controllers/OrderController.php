<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderAddRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Observers\CartObserver;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function addOrder(OrderAddRequest $_)
    {
        return OrderResource::make(OrderService::addOrder());
    }

    public function getList() {
        return OrderResource::collection(OrderService::getList());
    }

    public function getTotal() {
        return OrderService::getTotalSum();
    }

    public function deleteOrder(Order $order) {
        foreach ($order->carts as $value) {
            (new CartObserver())->deleted($value);
        }

        return response()->json([
            'success' => $order->delete()
        ]);
    }
}
