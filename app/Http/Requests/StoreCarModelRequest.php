<?php

namespace App\Http\Requests;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

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
            'name'=>['required','unique:models,name','string',new NotNumbersOnly()],
            'startYear'=>['required','integer'],
            'endYear'=>['required','integer','different:startYear'],
            'brand_id'=>['required','exists:brands,id','integer'],
            'image_start_year'=>['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'image_end_year'=>['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'status'=>['required','integer','in:0,1']
        ];
    }
}
