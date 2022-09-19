<?php

namespace App\Domain\Products\Enums;

enum Currency: string
{
    case Euro = 'EUR';
    case US_Dollar = 'USD';
}
