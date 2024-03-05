<?php

namespace App\Services\Interfaces\BaseInterfaces;

use Illuminate\Http\JsonResponse;

interface ReadInterface
{
    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function read(int $id): JsonResponse;
}
