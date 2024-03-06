<?php

namespace App\Services\Repositories\DistrictRepository;

use App\Models\District;
use App\Services\Interfaces\BaseInterfaces\AllModelInterface;
use App\Services\Interfaces\BaseInterfaces\GetByIdInterface;
use Illuminate\Database\Eloquent\Collection;

class BaseDistrictRepository implements GetByIdInterface, AllModelInterface
{

    /**
     * @param int $id
     *
     * @return District|null
     */
    public function getById(int $id): ?District
    {
        return District::query()->select(['id', 'name'])->with('hotels')->find($id);
    }


    /**
     * @return Collection
     */
    public function getModels(): Collection
    {
        return District::query()->select(['id', 'name'])->with('hotels')->get();
    }
}
