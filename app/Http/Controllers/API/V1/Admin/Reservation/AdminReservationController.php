<?php

namespace App\Http\Controllers\API\V1\Admin\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Admin\Reservation\ReservationCreateRequest;
use App\Services\Interfaces\ReservationInterface\AdminReservationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    /**
     * @param AdminReservationInterface $adminReservation
     *
     * @return void
     */
    public function __construct(private AdminReservationInterface $adminReservation)
    {
        //
    }


    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return $this->adminReservation->getAll();
    }


    /**
     * @param ConceptCreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(ReservationCreateRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->adminReservation->create(data_: [
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
        return $this->adminReservation->read(id: $id);
    }


    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function customerReservations(int $customer): JsonResponse
    {
        return $this->adminReservation->customerReservations(customerID: $customer);
    }


    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        return $this->adminReservation->delete(id: $id);
    }
}
