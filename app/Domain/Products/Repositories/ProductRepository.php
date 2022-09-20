<?php

namespace App\Domain\Products\Repositories;

use App\Domain\Products\DataTransferObjects\FilterParamsDTO;
use App\Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public static function findAll(FilterParamsDTO $filterParamsDTO): Collection
    {
        return Product::where($filterParamsDTO->toArray())->get();
    }
}
