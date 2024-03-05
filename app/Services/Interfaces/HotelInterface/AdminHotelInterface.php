<?php

namespace App\Services\Interfaces\HotelInterface;

use App\Models\Hotel;
use App\Services\Interfaces\BaseInterfaces\CrudInterface;
use App\Services\Interfaces\BaseInterfaces\GetByIdInterface;
use App\Services\Interfaces\BaseInterfaces\ListInterface;

interface AdminHotelInterface extends ListInterface, CrudInterface, GetByIdInterface
{
    //
}
