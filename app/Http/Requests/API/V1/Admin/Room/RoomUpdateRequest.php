<?php

namespace App\Http\Requests\API\V1\Admin\Room;

use Illuminate\Foundation\Http\FormRequest;

class RoomUpdateRequest extends FormRequest
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
            'id'       => 'required|numeric|min:1|exists:rooms,id',
            'name'     => 'required|string|min:1|max:255',
            'hotel_id' => 'required|numeric|min:1|exists:hotels,id',
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
            'id'       => 'Oda ID',
            'name'     => 'Oda Adı',
            'hotel_id' => 'Otel ID',
        ];
    }
}
