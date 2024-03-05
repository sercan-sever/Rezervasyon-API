<?php

namespace App\Enums;

enum TokensExpireDay: int
{
    case PERSONALACCESS = 2;
    case REFRESH = 5;
    case ALL = 10;
}
