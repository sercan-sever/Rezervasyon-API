<?php

namespace App\Http\Requests\API\V1\Customer\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class ReservationCreateRequest extends FormRequest
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
            'customer_id'     => 'required|numeric|min:1|exists:users,id',
            'hotel_id'        => 'required|numeric|min:1|exists:hotels,id',
            'room_id'         => 'required|numeric|min:1|exists:rooms,id',
            'concept_id'      => 'required|numeric|min:1|exists:concepts,id',
            'total_nights'    => 'required|numeric|min:1|max:60',
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
            'customer_id'     => 'Müşteri ID',
            'hotel_id'        => 'Otel ID',
            'room_id'         => 'Oda ID',
            'concept_id'      => 'Konsept ID',
            'total_nights'    => 'Toplam Gece',
        ];
    }
}
