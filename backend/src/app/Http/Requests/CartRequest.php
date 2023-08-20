<?php

namespace App\Http\Requests;

use App\Http\Requests\Trait\CartAccessTrait;

class CartRequest extends APIRequest
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
        return [
            //
        ];
    }
}
