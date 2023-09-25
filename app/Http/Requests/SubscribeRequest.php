<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class SubscribeRequest extends FormRequest
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
            'items' => 'required|array',
            'items.*.item_id' => 'required',
            'items.*.type' => 'nullable',
            'items.*.quantity' => 'required',
            'items.*.buy_date' => 'required',
            'items.*.amount' => 'required',
            'items.*.payment_method' => 'required',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => 0,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'meta' => [
                    'method' => $this->getMethod(),
                    'endpoint' => $this->path(),
                    'limit' => $this->input('limit', 0),
                    'offset' => $this->input('offset', 0),
                    'total' => 0,
                ],
                'data' => [
                    'message' => 'The given data was invalid.',
                    'errors' => $validator->errors(),
                ],
                'duration' => (float)sprintf("%.3f", (microtime(true) - LARAVEL_START)),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
