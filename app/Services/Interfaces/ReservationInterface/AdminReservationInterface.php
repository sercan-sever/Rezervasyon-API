<?php

namespace App\Services\Interfaces\ReservationInterface;

use App\Models\Reservation;
use App\Services\Interfaces\BaseInterfaces\CreateInterface;
use App\Services\Interfaces\BaseInterfaces\DeleteInterface;
use App\Services\Interfaces\BaseInterfaces\GetByIdInterface;
use App\Services\Interfaces\BaseInterfaces\ListInterface;
use App\Services\Interfaces\BaseInterfaces\ReadInterface;
use Illuminate\Http\JsonResponse;

interface AdminReservationInterface extends CreateInterface, ReadInterface, DeleteInterface, ListInterface
{

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function customerReservations(int $customerID): JsonResponse;
}
