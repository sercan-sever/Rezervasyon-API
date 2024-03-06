<?php

namespace App\Services\Repositories\RoomRepository;

use App\Http\Resources\Room\RoomConceptResource;
use App\Http\Resources\Room\RoomResource;
use App\Models\Room;
use App\Services\Interfaces\RoomInterface\AdminRoomInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AdminRoomRepository extends BaseRoomRepository implements AdminRoomInterface
{
    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $rooms = $this->getModels();


        if ($rooms->isEmpty())
            return response()->json(['success' => false, 'message' => 'Oda Mevcut Değil !!!'], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json([
            'success' => true,
            'message' => 'Tüm Odalar',
            'data' => [
                'rooms' => RoomResource::collection(resource: $rooms),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * @param array|Collection $data_
     *
     * @return JsonResponse
     */
    public function create(array|Collection $data_): JsonResponse
    {
        $room = Room::query()->create([
            'name'     => $data_['name'],
            'hotel_id' => $data_['hotel_id']
        ]);


        if (empty($room))
            return response()->json([
                'success' => false,
                'message' => 'Ekleme İşleminde Bir Sorun Oluştu. Lütfen Girişleri Kontrol Ederek Tekrar Deneyiniz !!!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json([
            'success' => true,
            'message' => 'Başarıyla Eklendi',
            'data' => [
                'room' => new RoomResource(resource: $room),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function read(int $id): JsonResponse
    {
        $room = $this->getById(id: $id);

        if (empty($room))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Oda Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);


        return response()->json([
            'success' => true,
            'message' => $room?->name . ' Detayı',
            'data' => [
                'room' => new RoomConceptResource(resource: $room),
            ]
        ], Response::HTTP_OK);
    }


    /**
     * @param array|Collection $data_
     *
     * @return JsonResponse
     */
    public function update(array|Collection $data_): JsonResponse
    {
        $room = $this->getById(id: $data_['id']);

        if (empty($room))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Oda Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);


        $update = $room->update([
            'name'     => $data_['name'],
            'hotel_id' => $data_['hotel_id']
        ]);

        if (!$update)
            return response()->json([
                'success' => false,
                'message' => 'Güncelleme İşleminde Bir Sorun Oluştu. Lütfen Girişleri Kontrol Ederek Tekrar Deneyiniz !!!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        /**
         *
         * Modelin resource içerisinde relation alanını güncellemesi için yapılmıştır.
         * Aksi taktirde bir önceki relation verisini göstermektedir.
         *
         */
        $room->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Başarıyla Güncellendi',
            'data' => [
                'room' => new RoomResource(resource: $room),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $room = $this->getById(id: $id);

        if (empty($room))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Oda Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);


        if (!$room->delete())
            return response()->json([
                'success' => false,
                'message' => 'Silme İşleminde Bir Sorun Oluştu. Lütfen Girişleri Kontrol Ederek Tekrar Deneyiniz !!!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json(['success' => true, 'message' => 'Başarıyla Silindi'], Response::HTTP_OK);
    }
}
