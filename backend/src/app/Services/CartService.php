<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CartService
{
    /**
     * @return LengthAwarePaginator
     */
    public static function cartList(): LengthAwarePaginator
    {
        return Cart::query()
            ->whereNull('order_id')
            ->where('customer_id', Auth::id())->paginate();
    }

    /**
     * Добавить или дополнить товар в корзине
     * @param array $validated
     * @return Cart
     */
    public static function createCart(array $validated): Cart
    {
        $cart = Cart::query()
            ->where('customer_id', Auth::id())
            ->where('product_id', $validated['product_id'])
            ->whereNull('order_id')
            ->first();
        if (!is_null($cart)) {
            $cart->quantity += $validated['quantity'];
        } else {
            $cart = new Cart();
            $cart->fill($validated);
        }
        $cart->save();
        return $cart;
    }

    /**
     * Запрос подсчета корзины
     * @return Builder
     */
    public static function getTotalCartsQuery(): Builder
    {
        return Cart::query()
            ->selectRaw('(products.cost * carts.quantity) as cost')
            ->addSelect('carts.quantity as quantity')
            ->addSelect('products.id as product_id')
            ->addSelect('products.name as name')
            ->leftJoin('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.customer_id', Auth::id());
    }

    /**
     * Получить количестов товаров с итоговой стоимостью
     * @return Collection
     */
    public static function getTotalCarts(): Collection
    {
        return self::getTotalCartsQuery()
            ->whereNull('carts.order_id')
            ->get();
    }

    public static function getAllTotalCartsQuery()
    {
        return Cart::query()
            ->selectRaw('SUM(products.cost * carts.quantity) as cost')
            ->selectRaw('SUM(carts.quantity) as quantity')
            ->leftJoin('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.customer_id', Auth::id());
    }

    /**
     * Подсчитать все товары и сумму
     * @return Collection
     */
    public static function getAllTotalCarts(): Collection
    {
        return self::getAllTotalCartsQuery()
            ->whereNull('carts.order_id')
            ->groupBy('carts.customer_id')
            ->get();
    }
}
