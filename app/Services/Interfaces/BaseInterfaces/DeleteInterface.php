<?php

namespace App\Services\Interfaces\BaseInterfaces;

use Illuminate\Http\JsonResponse;

interface DeleteInterface
{
    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse;
}
