<?php

namespace App\Http\Requests;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreCarModelRequest extends FormRequest
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
            'name'=>['required','string',new NotNumbersOnly()],
            'startYear'=>['required','integer'],
            'endYear'=>['required','integer','different:startYear'],
            'brand_id'=>['required','exists:brands,id','integer'],
            'image_start_year'=>['required','image','mimes:jpeg,png,jpg,gif,svg,webp','max:2048'],
            'image_end_year'=>['required','image','mimes:jpeg,png,jpg,gif,svg,webp','max:2048'],
            'status'=>['required','integer','in:0,1']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
