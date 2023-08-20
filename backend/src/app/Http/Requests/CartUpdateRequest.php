<?php

namespace App\Http\Requests;

use App\Http\Requests\Trait\CartAccessTrait;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Validation\Rule;

class CartUpdateRequest extends APIRequest
{
    use CartAccessTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->toAccess();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $product = Cart::query()->find($this->cart_id)?->product;
        return [
            'product_id' => [
                'required',
                'integer',
                Rule::exists(Product::class, 'id'),
                Rule::in([$product->id])
            ],
            'quantity' => [
                'required',
                'integer',
                'min: 1',
                'max: ' . ($product?->quantity ?? 1)
            ]
        ];
    }

    public function attributes()
    {
        return trans('lang::cart/cart');
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'cart_id' => request()->route('cart')?->id
        ]);
    }
}
