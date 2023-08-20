<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    /**
     * Отправить заказы на оформление
     * @return Order|null
     */
    public static function addOrder(): ?Order
    {
        $order = null;
        $cart = Cart::query()
            ->where('customer_id', Auth::id())
            ->whereNull('order_id');
        if ($cart->count()) {
            $order = new Order(['customer_id' => Auth::id()]);
            $order->save();
            $cart->update(['order_id' => $order->id]);
        }
        return $order;
    }

    /**
     * Список заказов
     * @return LengthAwarePaginator
     */
    public static function getList(): LengthAwarePaginator
    {
        return Order::query()
            ->where('customer_id', Auth::id())
            ->with('carts', function ($query) {
                $query->whereNotNull('order_id');
            })
            ->paginate();
    }

    /**
     * Итоговая стоимость всех заказов
     * @return Collection|array
     */
    public static function getTotalSum(): Collection|array
    {
        return Order::query()
            ->selectRaw("SUM(carts.quantity * products.cost) as total_sum")
            ->selectRaw("SUM(carts.quantity) as total_quantity")
            ->leftJoin('carts', 'carts.order_id', '=', 'orders.id')
            ->leftJoin('products', 'carts.product_id', '=', 'products.id')
            ->where('orders.customer_id', Auth::id())
            ->groupBy('orders.customer_id')
            ->get()->toArray();
    }
}
