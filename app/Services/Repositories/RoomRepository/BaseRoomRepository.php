<?php

namespace App\Services\Repositories\RoomRepository;

use App\Models\Room;
use App\Services\Interfaces\BaseInterfaces\AllModelInterface;
use App\Services\Interfaces\BaseInterfaces\GetByIdInterface;
use Illuminate\Database\Eloquent\Collection;

class BaseRoomRepository implements GetByIdInterface, AllModelInterface
{

    /**
     * @param int $id
     *
     * @return Room|null
     */
    public function getById(int $id): ?Room
    {
        return Room::query()->select(['id', 'hotel_id', 'name'])->with(['hotel', 'concepts'])->find($id);
    }

    /**
     * @return Collection
     */
    public function getModels(): Collection
    {
        return Room::query()->select(['id', 'hotel_id', 'name'])->with(['hotel', 'concepts'])->get();
    }
}
