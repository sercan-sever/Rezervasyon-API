<?php

namespace App\Services\Repositories\HotelRepository;

use App\Models\Hotel;
use App\Services\Interfaces\BaseInterfaces\AllModelInterface;
use App\Services\Interfaces\BaseInterfaces\GetByIdInterface;
use Illuminate\Database\Eloquent\Collection;

class BaseHotelRepository implements GetByIdInterface, AllModelInterface
{
    /**
     * @param int $id
     *
     * @return Hotel|null
     */
    public function getById(int $id): ?Hotel
    {
        return Hotel::query()->select(['id', 'district_id', 'name', 'slug'])->with(['district', 'rooms'])->find($id);
    }


    /**
     * @return Collection
     */
    public function getModels(): Collection
    {
        return Hotel::query()->select(['id', 'district_id', 'name', 'slug'])->with(['district', 'rooms'])->get();
    }
}
