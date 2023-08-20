<?php

namespace App\Http\Requests;

use App\Http\Requests\Trait\CartAccessTrait;
use App\Models\Product;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CartStoreRequest extends APIRequest
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
            'product_id' => [
                'required',
                'integer',
                Rule::exists(Product::class, 'id')
            ],
            'quantity' => [
                'required',
                'integer',
                'min: 1',
                'max: ' . Product::query()->find($this->product_id)?->quantity
            ],
            'customer_id' => [
                'required'
            ]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        parent::failedValidation($validator); // TODO: Change the autogenerated stub
    }

    public function attributes()
    {
        return trans('lang::cart/cart');
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'customer_id' => Auth::id()
        ]);
    }
}
