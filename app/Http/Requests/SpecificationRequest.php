<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SpecificationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'paneling_id'=>['required','integer'],
            'model_id'=>['required','integer'],
            'brand_id'=>['required','integer'],
            'car_chairs'=>['required','string','in:2,3,5'],
            'price'=>['required','numeric'],
            'is_connect'=>['required','in:0,1']
        ];
    }
        protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
            'status' => 'failed',
            'errors' => $validator->errors(),
        ], 422));
    }

}
