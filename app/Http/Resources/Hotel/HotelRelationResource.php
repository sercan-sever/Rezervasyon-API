<?php

namespace App\Http\Resources\Hotel;

use App\Http\Resources\District\DistrictResource;
use App\Http\Resources\Room\RoomConceptResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelRelationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'slug'     => $this->slug,
            'district' => new DistrictResource(resource: $this->district),
            'rooms'    => RoomConceptResource::collection(resource: $this->rooms)
        ];
    }
}
