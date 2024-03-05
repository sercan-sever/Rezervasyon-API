<?php

namespace App\Http\Requests\API\V1\Customer\Auth;

use Illuminate\Foundation\Http\FormRequest;

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
            'name'     => 'required|string|min:1|max:255|unique:users,name',
            'email'    => 'required|email|min:6|max:255|unique:users,email',
            'password' => 'required|string|min:6|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'name'     => 'Kullanıcı Adı',
            'email'    => 'E-Posta Adresi',
            'password' => 'Şifre',
        ];
    }
}
