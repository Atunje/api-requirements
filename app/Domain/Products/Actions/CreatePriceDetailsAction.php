<?php

namespace App\Domain\Products\Actions;

use App\Domain\Products\DataTransferObjects\PriceDetailsDTO;
use App\Domain\Products\Enums\Category;
use App\Domain\Products\Models\Product;

class CreatePriceDetailsAction
{
    private const SPECIAL_SKU = '000003';
    private const INSURANCE_DISCOUNT = 0.3;
    private const SPECIAL_SKU_DISCOUNT = 0.15;

    public function __construct(private readonly Product $product)
    {
        //
    }

    public function __invoke(): array
    {
        $discount_percentage = $this->getDiscountPercentage();
        $discount = $this->product->price * $discount_percentage;

        $final_price = $this->product->price - $discount;

        $priceDetail = new PriceDetailsDTO(
            $this->product->price,
            $discount_percentage,
            $final_price
        );

        return $priceDetail->toArray();
    }

    private function getDiscountPercentage(): float
    {
        $discount_percentage = 0;

        if ($this->product->category === Category::Insurance) {
            $discount_percentage = self::INSURANCE_DISCOUNT;
        }

        if ($this->product->sku === self::SPECIAL_SKU) {
            $discount_percentage = self::SPECIAL_SKU_DISCOUNT;
        }

        return $discount_percentage;
    }
}
