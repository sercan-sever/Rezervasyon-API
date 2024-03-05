<?php

namespace App\Http\Controllers\API\V1\Admin\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Admin\Hotel\HotelCreateRequest;
use App\Http\Requests\API\V1\Admin\Hotel\HotelUpdateRequest;
use App\Services\Interfaces\HotelInterface\AdminHotelInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminHotelController extends Controller
{
    /**
     * @param AdminHotelInterface $adminHotel
     *
     * @return void
     */
    public function __construct(private AdminHotelInterface $adminHotel)
    {
        //
    }


    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return $this->adminHotel->getAll();
    }


    /**
     * @param HotelCreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(HotelCreateRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->adminHotel->create(data_: [
            'name'        => $valid['name'],
            'district_id' => $valid['district_id'],
        ]);
    }


    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function detail(int $id): JsonResponse
    {
        return $this->adminHotel->read(id: $id);
    }


    /**
     * @param HotelUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(HotelUpdateRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->adminHotel->update(data_: [
            'id'          => $valid['id'],
            'name'        => $valid['name'],
            'district_id' => $valid['district_id'],
        ]);
    }


    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        return $this->adminHotel->delete(id: $id);
    }
}
