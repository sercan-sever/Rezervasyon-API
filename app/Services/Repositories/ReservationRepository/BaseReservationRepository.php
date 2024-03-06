<?php

namespace App\Services\Repositories\ReservationRepository;

use App\Models\Reservation;
use App\Services\Interfaces\BaseInterfaces\AllModelInterface;
use App\Services\Interfaces\BaseInterfaces\GetByIdInterface;
use Illuminate\Database\Eloquent\Collection;

class BaseReservationRepository implements GetByIdInterface, AllModelInterface
{
    private array $select_ = ['id', 'customer_id', 'hotel_id', 'room_id', 'concept_id', 'total_nights', 'price_per_night', 'total_price'];
    private array $with_ = ['customer', 'hotel', 'room', 'concept'];

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
     * @return Collection
     */
    public function getModels(): Collection
    {
        return Reservation::query()->select($this->select_)->with($this->with_)->get();
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
