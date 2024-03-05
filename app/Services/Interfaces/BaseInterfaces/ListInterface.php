<?php

namespace App\Services\Interfaces\BaseInterfaces;

use Illuminate\Http\JsonResponse;

interface ListInterface
{
    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse;
}
