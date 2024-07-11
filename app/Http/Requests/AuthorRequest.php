<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
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
            'name' => 'required|string|max:250',
            'email' => ['required','email','max:250',Rule::unique('users')->ignore($this->user()->id),],
            'password' => 'required|string|min:8|confirmed',
            'country' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'file' => 'required|file|mimetypes:application/pdf|max:5048'
        ];
    }
}
