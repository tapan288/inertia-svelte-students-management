<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'class_id' => ['required', 'exists:classes,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'phone_number' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:students,email'],
        ];
    }
}
