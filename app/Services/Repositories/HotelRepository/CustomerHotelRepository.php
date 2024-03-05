<?php

namespace App\Services\Repositories\HotelRepository;

use App\Http\Resources\Hotel\HotelResource;
use App\Models\Hotel;
use App\Services\Interfaces\HotelInterface\CustomerHotelInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CustomerHotelRepository implements CustomerHotelInterface
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
        return response()->json();
    }
}
