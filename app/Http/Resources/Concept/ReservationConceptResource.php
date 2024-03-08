<?php

namespace App\Http\Resources\Concept;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class ReservationConceptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'price'         => Number::currency($this->price, in: config('app.locale_price'), locale: config('app.locale')),
            'name'          => $this->name,
            'open_for_sale' => [
                'value' => $this->open_for_sale,
                'label' => $this->open_for_sale->label()
            ],
        ];
    }
}
