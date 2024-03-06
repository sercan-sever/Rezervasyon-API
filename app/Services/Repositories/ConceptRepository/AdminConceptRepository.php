<?php

namespace App\Services\Repositories\ConceptRepository;

use App\Http\Resources\Concept\ConceptResource;
use App\Models\Concept;
use App\Services\Interfaces\ConceptInterface\AdminConceptInterface;
use App\Services\Repositories\RoomRepository\AdminRoomRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AdminConceptRepository extends BaseConceptRepository implements AdminConceptInterface
{
    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $concepts = $this->getModels();


        if ($concepts->isEmpty())
            return response()->json(['success' => false, 'message' => 'Konsept Mevcut Değil !!!'], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json([
            'success' => true,
            'message' => 'Tüm Konseptler',
            'data' => [
                'concepts' => ConceptResource::collection(resource: $concepts),
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
        $room = (new AdminRoomRepository())->getById(id: $data_['room_id']);

        if ($room->hotel_id != $data_['hotel_id'])
            return response()->json([
                'success' => false,
                'message' => 'Seçilen Otele Ait Böyle Bir Oda Bulunmamaktadır !!!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        $concept = Concept::query()->create([
            'hotel_id'      => $data_['hotel_id'],
            'room_id'       => $data_['room_id'],
            'price'         => $data_['price'],
            'name'          => $data_['name'],
            'open_for_sale' => $data_['open_for_sale'],
        ]);


        if (empty($concept))
            return response()->json([
                'success' => false,
                'message' => 'Ekleme İşleminde Bir Sorun Oluştu. Lütfen Girişleri Kontrol Ederek Tekrar Deneyiniz !!!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json([
            'success' => true,
            'message' => 'Başarıyla Eklendi',
            'data' => [
                'concept' => new ConceptResource(resource: $concept),
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
        $concept = $this->getById(id: $id);

        if (empty($concept))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Konsept Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);



        return response()->json([
            'success' => true,
            'message' => $concept?->name . ' Konsept Detayı',
            'data' => [
                'concept' => new ConceptResource(resource: $concept),
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
        $concept = $this->getById(id: $data_['id']);

        if (empty($concept))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Konsept Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);



        $room = (new AdminRoomRepository())->getById(id: $data_['room_id']);

        if ($room->hotel_id != $data_['hotel_id'])
            return response()->json([
                'success' => false,
                'message' => 'Seçilen Otele Ait Böyle Bir Oda Bulunmamaktadır !!!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);



        $update = $concept->update([
            'hotel_id'      => $data_['hotel_id'],
            'room_id'       => $data_['room_id'],
            'price'         => $data_['price'],
            'name'          => $data_['name'],
            'open_for_sale' => $data_['open_for_sale'],
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
        $concept->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Başarıyla Güncellendi',
            'data' => [
                'concept' => new ConceptResource(resource: $concept),
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
        $concept = $this->getById(id: $id);

        if (empty($concept))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Konsept Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);


        if (!$concept->delete())
            return response()->json([
                'success' => false,
                'message' => 'Silme İşleminde Bir Sorun Oluştu. Lütfen Girişleri Kontrol Ederek Tekrar Deneyiniz !!!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json(['success' => true, 'message' => 'Başarıyla Silindi'], Response::HTTP_OK);
    }
}
