<?php

namespace App\Http\Requests;

use App\Models\Cart;
use App\Rules\CartsIsProcessedRule;
use Illuminate\Support\Facades\Auth;

class OrderAddRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'carts' => [
                'required',
                new CartsIsProcessedRule()
            ]
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'carts' => (bool)Cart::query()->where('customer_id', Auth::id())->whereNull('order_id')->count()
        ]);
    }
}
