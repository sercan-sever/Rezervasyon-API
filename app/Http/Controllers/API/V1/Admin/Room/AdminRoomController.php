<?php

namespace App\Http\Controllers\API\V1\Admin\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Admin\Room\RoomCreateRequest;
use App\Http\Requests\API\V1\Admin\Room\RoomUpdateRequest;
use App\Services\Interfaces\RoomInterface\AdminRoomInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminRoomController extends Controller
{
    public function __construct(private AdminRoomInterface $adminRoom)
    {
        //
    }


    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        return $this->adminRoom->getAll();
    }


    /**
     * @param RoomCreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(RoomCreateRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->adminRoom->create(data_: [
            'name'     => $valid['name'],
            'hotel_id' => $valid['hotel_id']
        ]);
    }


    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function detail(int $id): JsonResponse
    {
        return $this->adminRoom->read(id: $id);
    }


    /**
     * @param RoomUpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(RoomUpdateRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->adminRoom->update(data_: [
            'id'       => $valid['id'],
            'name'     => $valid['name'],
            'hotel_id' => $valid['hotel_id']
        ]);
    }


    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        return $this->adminRoom->delete(id: $id);
    }
}
