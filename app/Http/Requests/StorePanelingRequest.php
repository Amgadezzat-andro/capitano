<?php

namespace App\Http\Requests;

use App\Rules\NotNumbersOnly;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StorePanelingRequest extends FormRequest
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
           'link'=> [ 'required','string', 'url'],
            'name'=>['required','unique:panelings,name','string',new NotNumbersOnly()],
            'description'=>['required','string',new NotNumbersOnly()],
            'category_id'=>['required','integer',
            Rule::exists('categories','id')->whereNull('deleted_at')
            ],
            'status'=>['required','in:0,1'],
            'image'=>['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],

        ];
    }
}
