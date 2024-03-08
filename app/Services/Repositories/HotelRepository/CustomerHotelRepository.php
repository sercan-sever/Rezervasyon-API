<?php

namespace App\Services\Repositories\HotelRepository;

use App\Http\Resources\District\DistrictHotelResource;
use App\Http\Resources\Hotel\HotelRelationResource;
use App\Http\Resources\Hotel\HotelResource;
use App\Models\Hotel;
use App\Services\Interfaces\HotelInterface\CustomerHotelInterface;
use App\Services\Repositories\DistrictRepository\BaseDistrictRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CustomerHotelRepository extends BaseHotelRepository implements CustomerHotelInterface
{
    private array $select_ = ['id', 'district_id', 'name', 'slug'];
    private array $with_ = ['district'];

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $hotels = Hotel::query()->select($this->select_)->with($this->with_)->get();

        if ($hotels->isEmpty())
            return response()->json(['success' => false, 'message' => 'Otel Mevcut Değil !!!'], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json([
            'success' => true,
            'message' => 'Tüm Oteller',
            'data' => [
                'hotels' => HotelResource::collection(resource: $hotels),
            ]
        ], Response::HTTP_OK);
    }


    /**
     * @param int $hotelID
     *
     * @return JsonResponse
     */
    public function getHotelDetail(int $hotelID): JsonResponse
    {
        $hotel = $this->getById(id: $hotelID);

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
     * @param int $hotelID
     *
     * @return JsonResponse
     */
    public function getDistricHotelList(int $districID): JsonResponse
    {
        $distric = (new BaseDistrictRepository())->getById(id: $districID);

        if (empty($distric))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Bölge Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);


        return response()->json([
            'success' => true,
            'message' => $distric?->name . ' Detayı',
            'data' => [
                'district' => new DistrictHotelResource(resource: $distric),
            ]
        ], Response::HTTP_OK);
    }
}
