<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\CartUpdateRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Services\CartService;

class CartController extends Controller
{
    public function index()
    {
        return CartResource::collection(CartService::cartList());
    }

    public function store(CartStoreRequest $request)
    {
        return CartResource::make(CartService::createCart($request->validated()));
    }

    public function update(Cart $cart, CartUpdateRequest $request)
    {
        $cart->update($request->validated());
        return CartResource::make($cart);
    }

    public function destroy(Cart $cart, CartRequest $_)
    {
        return response()->json([
            'success' => (bool)$cart->delete()
        ]);
    }

    public function total()
    {
        return CartService::getTotalCarts();
    }

    public function totalAll()
    {
        return CartService::getAllTotalCarts();
    }
}
