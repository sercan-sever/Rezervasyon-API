<?php

namespace App\Http\Resources\Room;

use App\Http\Resources\Hotel\HotelResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'hotel' => new HotelResource(resource: $this->hotel),
        ];
    }
}
