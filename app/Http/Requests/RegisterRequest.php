<?php

namespace App\Http\Requests;

use App\Rules\NotNumbersOnly;
use App\Rules\PhoneNumbers;
use App\Rules\StringOnly;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', new StringOnly()],
            'mobile' => ['required', 'unique:users,mobile', 'numeric', new PhoneNumbers()],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'email' => ['required', 'email', 'unique:users,email']

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
