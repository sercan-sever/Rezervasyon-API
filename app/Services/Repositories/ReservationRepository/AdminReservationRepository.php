<?php

namespace App\Services\Repositories\ReservationRepository;

use App\Http\Resources\Reservation\ReservationResource;
use App\Jobs\ProcessReservation;
use App\Models\Reservation;
use App\Services\Interfaces\ReservationInterface\AdminReservationInterface;
use App\Services\Repositories\ConceptRepository\AdminConceptRepository;
use App\Services\Repositories\UserRepository\CustomerRepository;
use App\Traits\ReservationPriceCalculation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AdminReservationRepository implements AdminReservationInterface
{
    use ReservationPriceCalculation;


    private array $select_ = ['id', 'customer_id', 'hotel_id', 'room_id', 'concept_id', 'total_nights', 'price_per_night', 'total_price'];
    private array $with_ = ['customer', 'hotel', 'room', 'concept'];

    /**
     * @return JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $reservations = Reservation::query()->select($this->select_)->with($this->with_)->paginate(50);

        if ($reservations->isEmpty())
            return response()->json(['success' => false, 'message' => 'Bir Rezervasyon Bulunamadı !!!'], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json([
            'success' => true,
            'message' => 'Tüm Rezervasyonlar',
            'data' => [
                'reservations' => ReservationResource::collection(resource: $reservations),
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
        $customer = (new CustomerRepository())->getById(id: $data_['customer_id']);

        if (empty($customer))
            return response()->json([
                'success' => false,
                'message' => 'Kullanıcı Kayıtlarımız İle Uyuşmuyor !!!'
            ], Response::HTTP_UNAUTHORIZED);


        $concept = (new AdminConceptRepository())->getById(id: $data_['concept_id']);

        if (empty($concept) || ($concept->hotel_id != $data_['hotel_id'] || $concept->room_id != $data_['room_id']))
            return response()->json([
                'success' => false,
                'message' => 'Seçilen Bilgilere Ait Bir Otel, Oda veya Konsept Bulunamadı. Bilgilerinizi Kontrol Ederek Tekrar Deneyiniz !!!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        if ($concept->forSaleNo())
            return response()->json([
                'success' => false,
                'message' => 'Bu Otel Konsepti Satışa Açık Değildir !!!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);



        $totalPrice = $this->pricePerNight(night: $data_['total_nights'], price: $concept?->price);

        $reservation = Reservation::query()->create([
            'customer_id'     => $data_['customer_id'],
            'hotel_id'        => $data_['hotel_id'],
            'room_id'         => $data_['room_id'],
            'concept_id'      => $data_['concept_id'],
            'total_nights'    => $data_['total_nights'],
            'price_per_night' => $concept?->price,
            'total_price'     => $totalPrice,
        ]);


        if (empty($reservation))
            return response()->json([
                'success' => false,
                'message' => 'Rezervasyon İşleminde Bir Sorun Oluştu. Lütfen Girişleri Kontrol Ederek Tekrar Deneyiniz !!!'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);


        return response()->json([
            'success' => true,
            'message' => 'Başarıyla Rezervasyon Oluşturuldu.',
            'data' => [
                'reservation' => new ReservationResource(resource: $reservation),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function customerReservations(int $customerID): JsonResponse
    {
        $reservations = $this->getByCustomerRezervations(customerID: $customerID);

        if ($reservations->isEmpty())
            return response()->json(['success' => false, 'message' => 'Bu Kullanıcıya Ait Bir Rezervasyon Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);


        return response()->json([
            'success' => true,
            'message' => 'Rezervasyonlar',
            'data' => [
                'reservations' => ReservationResource::collection(resource: $reservations),
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
        $reservation = $this->getById(id: $id);

        if (empty($reservation))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Rezervasyon Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);


        return response()->json([
            'success' => true,
            'message' => 'Rezervasyon Detayı',
            'data' => [
                'reservation' => new ReservationResource(resource: $reservation),
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
        $reservation = $this->getById(id: $id);

        if (empty($reservation))
            return response()->json(['success' => false, 'message' => 'Böyle Bir Rezervasyon Mevcut Değil !!!'], Response::HTTP_NOT_FOUND);



        if (!$reservation->delete())
            return response()->json([
                'success' => false,
                'message' => 'Silme İşleminde Bir Sorun Oluştu. Lütfen Girişleri Kontrol Ederek Tekrar Deneyiniz !!!',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);



        return response()->json(['success' => true, 'message' => 'Başarıyla Silindi'], Response::HTTP_OK);
    }


    /**
     * @param int $id
     *
     * @return Reservation|null
     */
    public function getById(int $id): ?Reservation
    {
        return Reservation::query()->select($this->select_)->with($this->with_)->find($id);
    }


    /**
     * @param int $customerID
     *
     * @return Collection|null
     */
    public function getByCustomerRezervations(int $customerID): Collection
    {
        return Reservation::query()->select($this->select_)->with($this->with_)->whereCustomerId($customerID)->get();
    }

}
