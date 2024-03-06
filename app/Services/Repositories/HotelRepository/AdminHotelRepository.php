<?php

namespace App\Services\Repositories\HotelRepository;

use App\Http\Resources\Hotel\HotelRelationResource;
use App\Http\Resources\Hotel\HotelResource;
use App\Models\Hotel;
use App\Services\Interfaces\HotelInterface\AdminHotelInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AdminHotelRepository extends BaseHotelRepository implements AdminHotelInterface
{

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $hotels = $this->getModels();

        if ($hotels->isEmpty())
            return response()->json(['success' => false, 'message' => 'Oteller Mevcut Değil !!!'], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json([
            'success' => true,
            'message' => 'Tüm Oteller',
            'data' => [
                'hotels' => HotelResource::collection(resource: $hotels),
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
        $hotel = Hotel::query()->create([
            'name'        => $data_['name'],
            'district_id' => $data_['district_id']
        ]);

        if (empty($hotel))
            return response()->json([
                'success' => false,
                'message' => 'Ekleme İşleminde Bir Sorun Oluştu. Lütfen Girişleri Kontrol Ederek Tekrar Deneyiniz !!!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json([
            'success' => true,
            'message' => 'Başarıyla Eklendi',
            'data' => [
                'hotel' => new HotelResource(resource: $hotel),
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
        $hotel = $this->getById(id: $id);

        if (empty($hotel))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Otel Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);


        return response()->json([
            'success' => true,
            'message' => $hotel?->name . ' Detayı',
            'data' => [
                'hotel' => new HotelRelationResource(resource: $hotel),
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
        $hotel = $this->getById(id: $data_['id']);

        if (empty($hotel))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Otel Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);


        $hotel->slug = null;
        $update = $hotel->update([
            'name' => $data_['name'],
            'district_id' => $data_['district_id']
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
        $hotel->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Başarıyla Güncellendi',
            'data' => [
                'hotel' => new HotelRelationResource(resource: $hotel),
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
        $hotel = $this->getById(id: $id);

        if (empty($hotel))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Otel Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);


        if (!$hotel->delete())
            return response()->json([
                'success' => false,
                'message' => 'Silme İşleminde Bir Sorun Oluştu. Lütfen Girişleri Kontrol Ederek Tekrar Deneyiniz !!!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json(['success' => true, 'message' => 'Başarıyla Silindi'], Response::HTTP_OK);
    }
}
