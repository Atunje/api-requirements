<?php

namespace App\Domain\Products\DataTransferObjects;

use App\Domain\Products\Enums\Currency;

class PriceDetailsDTO
{
    public function __construct(
        private readonly float $original,
        private readonly float $discount_percentage,
        private readonly float $final,
        private readonly Currency $currency = Currency::Euro
    ) {
        //
    }

    /**
     * converts instance to an array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'original' => $this->original,
            'final' => $this->final,
            'discount_percentage' => $this->discount_percentage == 0 ? 'null' : $this->discount_percentage * 100 . '%',
            'currency' => $this->currency,
        ];
    }
}
