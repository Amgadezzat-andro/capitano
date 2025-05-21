<?php

namespace App\Http\Requests;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCarModelRequest extends FormRequest
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
        $id= request()->route('model');
        
        return [
            'name'=>['required',
            Rule::unique('models', 'name')->ignore($id)
            ,'string',new NotNumbersOnly()],
            'startYear'=>['required','integer'],
            'endYear'=>['required','integer','different:startYear'],
            'brand_id'=>['required','integer',
            Rule::exists('brands','id')->whereNull('deleted_at')
            ],
            'image_start_year'=>['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'image_end_year'=>['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'status'=>['in:0,1','integer']
        ];
    }
}
