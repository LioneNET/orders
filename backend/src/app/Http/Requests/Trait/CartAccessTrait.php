<?php

namespace App\Http\Requests\Trait;

use Illuminate\Support\Facades\Auth;

trait CartAccessTrait
{
    /**
     * Есть ли доступ к заказу у заказчика
     * @return bool
     */
    public function toAccess(): bool
    {
        return request()->route('cart')?->customer_id == Auth::id();
    }
}
