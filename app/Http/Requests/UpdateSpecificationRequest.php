<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSpecificationRequest extends FormRequest
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
            'paneling_id'=>['required','integer',Rule::exists('panelings','id')->whereNull('deleted_at')],
            'model_id'=>['required','integer',Rule::exists('models', 'id')->whereNull('deleted_at')],
            'brand_id'=>['required','integer',Rule::exists('brands','id')->whereNull('deleted_at')],
            'car_chairs'=>['required','string','in:2,3,5'],
            'price'=>['required','numeric'],
            'bag_price'=>['nullable','numeric'],
            'is_connect'=>['nullable','in:0,1']
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
