<?php

namespace App\Services\Interfaces\BaseInterfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

interface CreateInterface
{
    /**
     * @param array|Collection $data_
     *
     * @return JsonResponse
     */
    public function create(array|Collection $data_): JsonResponse;
}
