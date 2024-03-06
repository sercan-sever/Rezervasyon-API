<?php

namespace App\Services\Interfaces\ReservationInterface;

use App\Services\Interfaces\BaseInterfaces\CreateInterface;
use App\Services\Interfaces\BaseInterfaces\DeleteInterface;
use App\Services\Interfaces\BaseInterfaces\ListInterface;
use App\Services\Interfaces\BaseInterfaces\ReadInterface;
use Illuminate\Http\JsonResponse;

interface CustomerReservationInterface extends CreateInterface, ReadInterface, DeleteInterface, ListInterface
{
    //
}
