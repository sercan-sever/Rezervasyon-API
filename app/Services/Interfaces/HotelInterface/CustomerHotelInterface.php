<?php

namespace App\Services\Interfaces\HotelInterface;

use App\Services\Interfaces\BaseInterfaces\ListInterface;
use Illuminate\Http\JsonResponse;

interface CustomerHotelInterface extends ListInterface
{
    /**
     * @param int $hotelID
     *
     * @return JsonResponse
     */
    public function getHotelDetail(int $hotelID): JsonResponse;


    /**
     * @param int $hotelID
     *
     * @return JsonResponse
     */
    public function getDistricHotelList(int $districID): JsonResponse;
}
