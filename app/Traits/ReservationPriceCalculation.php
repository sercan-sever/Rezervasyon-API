<?php

namespace App\Traits;

use Ramsey\Uuid\Type\Decimal;

trait ReservationPriceCalculation
{
    /**
     * @param int $night
     * @param float $price
     *
     * @return float
     */
    public function pricePerNight(int $night, float $price): float
    {
        return $price * $night;
    }


}
