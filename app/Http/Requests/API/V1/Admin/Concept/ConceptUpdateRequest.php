<?php

namespace App\Http\Requests\API\V1\Admin\Concept;

use App\Enums\ForSale;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConceptUpdateRequest extends FormRequest
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
            'id'            => 'required|numeric|min:1|exists:concepts,id',
            'hotel_id'      => 'required|numeric|min:1|exists:hotels,id',
            'room_id'       => 'required|numeric|min:1|exists:rooms,id',
            'price'         => 'required|numeric|min:1|between:1.00,9999999999.99',
            'name'          => 'required|string|min:1|max:255',
            'open_for_sale' => 'required|', Rule::enum(ForSale::class),
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
            'id'            => 'Konsept ID',
            'hotel_id'      => 'Otel ID',
            'room_id'       => 'Oda ID',
            'price'         => 'Fiyat',
            'name'          => 'Konsept Adı',
            'open_for_sale' => 'Satışa Açık mı ?',
        ];
    }
}
