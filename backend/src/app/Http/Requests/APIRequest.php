<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class APIRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'errors' => [
                        'fields' => $validator->errors(),
                    ],
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                [],
            )
        );
    }
}
