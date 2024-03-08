<?php

namespace App\Services\Repositories\DiscountRepository;

use App\Models\Concept;
use App\Models\Reservation;
use App\Traits\RedisStore;
use Illuminate\Database\Eloquent\Collection;

class CustomerDiscountRepository
{
    use RedisStore;


    private float $totalDiscount = 0;
    private float $discountAmount = 0;
    private float $minPrice = 0;
    private array $data_ = [];


    private float $totalAmount = 0;
    private int $districtId = 0;
    private int $nights = 0;

    public function __construct(private Reservation $reservation)
    {
        $this->totalAmount = $reservation->total_price;
        $this->districtId = $reservation->hotel->district_id;
        $this->nights = $reservation->total_nights;
    }

    // İndirim Kuralları
    /**
     * @return array
     */
    public function calculateDiscount(): array
    {

        /*
        |--------------------------------------------------------------------------
        | - Toplam 20000TL ve üzerinde rezervasyon yapan bir müşteri, rezervasyonun tamamından %10 indirim uygulanır.
        |--------------------------------------------------------------------------
        */
        if ($this->totalAmount >= 20000.00) {
            $this->discountAmount += $this->totalAmount * 0.10;
            $this->totalDiscount += $this->discountAmount;

            $this->totalAmount -= $this->discountAmount;

            $this->data_[] = [
                "discount_reason" => "10_PERCENT_OVER_20000",
                "discount_amount" => $this->discountAmount,
                "subtotal"        => $this->totalAmount
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | - 1 ID'li bölgeye (district) ait bir otelden herhangi bir konseptte 7 veya daha fazla gece için rezervasyon yapıldığında, bir gece ücretsiz olarak tanımlanır.
        |--------------------------------------------------------------------------
        */
        if ($this->districtId == 1 && $this->nights >= 7) {
            $this->reservation->total_nights += 1;
            $this->totalDiscount += $this->reservation->price_per_night;

            $this->data_[] = [
                "discount_reason" => "BUY_7_GET_1",
                "discount_amount" => $this->reservation->price_per_night,
                "subtotal"        => $this->totalAmount
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | - 2 ID'li bölgeden (district) 2 veya daha fazla gece için rezervasyon yapıldığında, en ucuz konseptine %25 indirim uygulanır.
        |--------------------------------------------------------------------------
        */
        if ($this->districtId == 2 && $this->nights >= 2) {
            $concept = $this->getCheapestConcept(concepts: $this->reservation->room->conceptMinPrice);

            if (!empty($concept)) {
                $this->minPrice = $concept->price - ($concept->price * 0.25);
                $this->totalDiscount += $this->minPrice;

                $this->cachePut(key: 'cache:discounts:users:' . $this->reservation->customer_id, value: ['concept_id' => $concept->id, 'min_price' => $this->minPrice], seconds: now()->addDay(3));

                $this->data_[] = [
                    "discount_reason" => "25_PERCENT_OFF_FOR_2_PLUS_NIGHTS_IN_DISTRICT_2",
                    "discount_amount" => $this->minPrice,
                    "subtotal"        => $this->totalAmount
                ];
            }
        }


        /*
        |--------------------------------------------------------------------------
        | - 3 ID'li bölgeden (district) 4 veya daha fazla gece için rezervasyon yapıldığında, %10 indirim uygulanır.
        |--------------------------------------------------------------------------
        */
        if ($this->districtId == 3 && $this->nights >= 4) {

            $this->discountAmount += $this->totalAmount * 0.10;
            $this->totalDiscount += $this->discountAmount;
            $this->totalAmount -= $this->discountAmount;

            $this->data_[] = [
                "discount_reason" => "10_PERCENT_OFF_FOR_4_PLUS_NIGHTS_IN_DISTRICT_3",
                "discount_amount" => $this->discountAmount,
                "subtotal"        => $this->totalAmount
            ];
        }


        $this->reservation->total_price = $this->totalAmount;
        $this->reservation->save();

        return !empty($this->totalDiscount)
            ? [
                'order_id' => $this->reservation->id,
                'discounts' => $this->data_,
                'total_discount' => $this->totalDiscount,
                'discounted_total' => $this->totalAmount,
            ]
            : [];
    }


    /**
     * @param array|Collection $concepts
     *
     * @return Concept|null
     */
    private function getCheapestConcept(array|Collection $concepts): ?Concept
    {
        return $concepts->first();
    }
}
