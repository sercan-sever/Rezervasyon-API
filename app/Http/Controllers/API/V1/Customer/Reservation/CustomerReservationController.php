<?php

namespace App\Http\Controllers\API\V1\Customer\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Customer\Reservation\ReservationCreateRequest;
use App\Services\Interfaces\ReservationInterface\CustomerReservationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerReservationController extends Controller
{
    /**
     * @param CustomerReservationInterface $customerReservation
     *
     * @return void
     */
    public function __construct(private CustomerReservationInterface $customerReservation)
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return $this->customerReservation->getAll();
    }


    /**
     * @param ReservationCreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(ReservationCreateRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->customerReservation->create(data_: [
            'customer_id'  => $valid['customer_id'],
            'hotel_id'     => $valid['hotel_id'],
            'room_id'      => $valid['room_id'],
            'concept_id'   => $valid['concept_id'],
            'total_nights' => $valid['total_nights'],
        ]);
    }


    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function detail(int $id): JsonResponse
    {
        return $this->customerReservation->read(id: $id);
    }



    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        return $this->customerReservation->delete(id: $id);
    }
}
