<?php


namespace App\Services\Interfaces\BaseInterfaces;

use Illuminate\Database\Eloquent\Model;

interface GetByIdInterface
{
    /**
     * @param int $id
     *
     * @return Model|null
     */
    public function getById(int $id): ?Model;
}
