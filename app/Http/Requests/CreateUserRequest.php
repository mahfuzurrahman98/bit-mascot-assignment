<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        // dd the request data
        // dd($this->all());
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'dob' => 'required|date',
            'id_verification_file' => 'required|file|mimes:pdf',
        ];
    }

    public function failedValidation(Validator $validator) {
        // dd($validator->errors());
        throw new HttpResponseException(
            response()->redirectToRoute('signup')->withErrors($validator)->withInput()
        );
    }
}
