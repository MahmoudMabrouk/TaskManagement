<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'department_id' => ['required', 'exists:departments,id'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'regex:/^[0-9]+$/', 'min_digits:11', 'max_digits:13'],
            'salary' => ['required', 'numeric'],
            'image' => ['nullable', 'image' ,'max:2048', 'mimes:jpg,peg,jpeg,png']
        ];

    }
}
