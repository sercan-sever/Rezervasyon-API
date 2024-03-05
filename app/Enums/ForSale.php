<?php

namespace App\Enums;

use App\Traits\EnumValues;

enum ForSale: int
{
    use EnumValues;

    case YES = 1;
    case NO  = 2;

    /**
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::YES => 'Satılık',
            self::NO => 'Satılık Değil',
            default => '',
        };
    }
}
