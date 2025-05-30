<?php

namespace App\Http\Requests;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        $id= request()->route('category');
        return [
            'name'=>['required',"unique:categories,name,$id",'string',new NotNumbersOnly(),'unique:categories,name,except,id'],
            'image'=>['image','mimes:jpeg,png,jpg,gif,svg,webp','max:2048']
        ];
    }
}
