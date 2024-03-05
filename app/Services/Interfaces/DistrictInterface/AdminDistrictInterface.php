<?php

namespace App\Services\Interfaces\DistrictInterface;

use App\Models\District;
use App\Services\Interfaces\BaseInterfaces\CrudInterface;
use App\Services\Interfaces\BaseInterfaces\GetByIdInterface;
use App\Services\Interfaces\BaseInterfaces\ListInterface;

interface AdminDistrictInterface extends ListInterface, CrudInterface, GetByIdInterface
{
    //
}
