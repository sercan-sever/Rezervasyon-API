<?php

namespace App\Http\Controllers\API\V1\Admin\District;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Admin\District\DistrictCreateRequest;
use App\Http\Requests\API\V1\Admin\District\DistrictUpdateRequest;
use App\Services\Interfaces\DistrictInterface\AdminDistrictInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminDistrictController extends Controller
{
    /**
     * @param AdminDistrictInterface $adminDistrict
     *
     * @return void
     */
    public function __construct(private AdminDistrictInterface $adminDistrict)
    {
        //
    }


    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return $this->adminDistrict->getAll();
    }


    /**
     * @param HotelCreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(DistrictCreateRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->adminDistrict->create(data_: ['name' => $valid['name']]);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function detail(int $id): JsonResponse
    {
        return $this->adminDistrict->read(id: $id);
    }


    /**
     * @param DistrictUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(DistrictUpdateRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->adminDistrict->update(data_: ['id' => $valid['id'],'name' => $valid['name']]);
    }


    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        return $this->adminDistrict->delete(id: $id);
    }
}
