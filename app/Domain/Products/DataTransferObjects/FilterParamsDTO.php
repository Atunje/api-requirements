<?php

namespace App\Domain\Products\DataTransferObjects;

class FilterParamsDTO
{
    public string $category;
    public string $price;

    public function toArray(): array
    {
        return (array) $this;
    }
}
