<?php

namespace App\Http\Requests;

class UserAuthRequest extends APIRequest
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
            'login'       => [
                'required'
            ],
            'password'    => [
                'required'
            ],
            'device_name' => [
                'required'
            ]
        ];
    }
}
