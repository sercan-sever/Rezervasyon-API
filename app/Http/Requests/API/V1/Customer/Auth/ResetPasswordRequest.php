<?php

namespace App\Http\Requests\API\V1\Customer\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email'                 => 'required|email|min:6|max:255',
            'password'              => 'required|string|min:6|max:255|confirmed',
            'password_confirmation' => 'required|string|min:6|max:255',
            'token'                 => 'required|string',
        ];
    }


    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function attributes(): array
    {
        return [
            'email'                 => 'E-Posta Adresi',
            'password'              => 'Şifre',
            'password_confirmation' => 'Şifre Tekrarı',
            'token'                 => 'Token',
        ];
    }
}
