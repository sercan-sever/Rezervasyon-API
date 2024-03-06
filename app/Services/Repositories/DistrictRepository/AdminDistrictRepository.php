<?php

namespace App\Services\Repositories\DistrictRepository;

use App\Http\Resources\District\DistrictResource;
use App\Models\District;
use App\Services\Interfaces\DistrictInterface\AdminDistrictInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AdminDistrictRepository extends BaseDistrictRepository implements AdminDistrictInterface
{

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $districts = $this->getModels();

        if ($districts->isEmpty())
            return response()->json([
                'success' => false,
                'message' => 'Bölgeler Mevcut Değil !!!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);



        return response()->json([
            'success' => true,
            'message' => 'Tüm Bölgeler',
            'data' => [
                'districts' => DistrictResource::collection(resource: $districts),
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
        $district = District::query()->create(['name' => $data_['name']]);

        if (empty($district))
            return response()->json([
                'success' => false,
                'message' => 'Ekleme İşleminde Bir Sorun Oluştu. Lütfen Girişleri Kontrol Ederek Tekrar Deneyiniz !!!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json([
            'success' => true,
            'message' => 'Başarıyla Eklendi',
            'data' => [
                'district' => new DistrictResource(resource: $district),
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
        $district = $this->getById(id: $id);

        if (empty($district))
            return response()->json([
                'success' => false,
                'message' => 'Böyle Bir Bölge Mevcut Değil !!!'
            ], Response::HTTP_NOT_FOUND);


        return response()->json([
            'success' => true,
            'message' => $district?->name . ' Detayı',
            'data' => [
                'district' => new DistrictResource(resource: $district),
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
        $district = $this->getById(id: $data_['id']);

        if (empty($district))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Bölge Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);


        if (!$district->update(['name' => $data_['name']]))
            return response()->json([
                'success' => false,
                'message' => 'Güncelleme İşleminde Bir Sorun Oluştu. Lütfen Girişleri Kontrol Ederek Tekrar Deneyiniz !!!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json([
            'success' => true,
            'message' => 'Başarıyla Güncellendi',
            'data' => [
                'district' => new DistrictResource(resource: $district),
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
        $district = $this->getById(id: $id);

        if (empty($district))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Bölge Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);


        if (!$district->delete())
            return response()->json([
                'success' => false,
                'message' => 'Silme İşleminde Bir Sorun Oluştu. Lütfen Girişleri Kontrol Ederek Tekrar Deneyiniz !!!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json(['success' => true, 'message' => 'Başarıyla Silindi'], Response::HTTP_OK);
    }
}
