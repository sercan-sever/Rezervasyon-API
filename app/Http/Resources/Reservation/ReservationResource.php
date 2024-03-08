<?php

namespace App\Http\Resources\Reservation;

use App\Http\Resources\Concept\ConceptNotRelationResource;
use App\Http\Resources\Concept\ReservationConceptResource;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Hotel\HotelResource;
use App\Http\Resources\Room\RoomNotRelationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'customer'        => new CustomerResource(resource: $this->customer),
            'hotel'           => new HotelResource(resource: $this->hotel),
            'room'            => new RoomNotRelationResource(resource: $this->room),
            'concept'         => new ReservationConceptResource(resource: $this->concept),
            'total_nights'    => $this->total_nights,
            'price_per_night' => Number::currency($this->price_per_night, in: config('app.locale_price'), locale: config('app.locale')),
            'total_price'     => Number::currency($this->total_price, in: config('app.locale_price'), locale: config('app.locale')),
        ];
    }
}
