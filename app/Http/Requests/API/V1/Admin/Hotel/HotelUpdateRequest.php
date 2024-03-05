<?php

namespace App\Http\Requests\API\V1\Admin\Hotel;

use Illuminate\Foundation\Http\FormRequest;

class HotelUpdateRequest extends FormRequest
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
            'id'          => 'required|numeric|min:1|exists:hotels,id',
            'name'        => 'required|string|min:1|max:255|unique:hotels,name,' . $this->id,
            'district_id' => 'required|numeric|min:1|exists:districts,id',
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
            'id'          => 'Otel ID',
            'name'        => 'Otel Adı',
            'district_id' => 'Bölge Kimliği',
        ];
    }
}
