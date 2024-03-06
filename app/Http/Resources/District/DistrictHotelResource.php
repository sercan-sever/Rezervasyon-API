<?php

namespace App\Http\Resources\District;

use App\Http\Resources\Hotel\HotelNotRelationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistrictHotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'hotels' => HotelNotRelationResource::collection(resource: $this->hotels),
        ];
    }
}
