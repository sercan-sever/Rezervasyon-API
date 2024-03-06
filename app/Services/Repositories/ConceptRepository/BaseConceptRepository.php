<?php

namespace App\Services\Repositories\ConceptRepository;

use App\Models\Concept;
use App\Services\Interfaces\BaseInterfaces\AllModelInterface;
use App\Services\Interfaces\BaseInterfaces\GetByIdInterface;
use Illuminate\Database\Eloquent\Collection;

class BaseConceptRepository implements GetByIdInterface, AllModelInterface
{
    /**
     * @param int $id
     *
     * @return Concept|null
     */
    public function getById(int $id): ?Concept
    {
        return Concept::query()->select(['id', 'hotel_id', 'room_id', 'price', 'name', 'open_for_sale'])->with(['hotel', 'room'])->find($id);
    }


    /**
     * @return Collection
     */
    public function getModels(): Collection
    {
        return Concept::query()->select(['id', 'hotel_id', 'room_id', 'price', 'name', 'open_for_sale'])->with(['hotel', 'room'])->get();
    }
}
