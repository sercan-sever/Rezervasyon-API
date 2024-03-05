<?php

namespace App\Http\Controllers\API\V1\Customer\Hotel;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\HotelInterface\CustomerHotelInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerHotelController extends Controller
{
    /**
     * @param CustomerHotelInterface $customerHotel
     *
     * @return void
     */
    public function __construct(private CustomerHotelInterface $customerHotel)
    {
        //
    }


    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return $this->customerHotel->getAll();
    }

    /**
     * @return JsonResponse
     */
    public function hotelDetail(int $id): JsonResponse
    {
        return $this->customerHotel->getHotelDetail(hotelID: $id);
    }
}
