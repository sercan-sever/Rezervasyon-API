<?php

namespace App\Services\Interfaces\BaseInterfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

interface UpdateInterface
{
    /**
     * @param array|Collection $data_
     *
     * @return JsonResponse
     */
    public function update(array|Collection $data_): JsonResponse;
}
