<?php

namespace App\Enums;

enum ThrottleLimit: int {
    case APIPERMINUTE = 60;
    case APIPERDAY = 5;
}
