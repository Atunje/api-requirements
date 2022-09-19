<?php

namespace App\Domain\Products\Models;

use App\Domain\Products\Enums\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product
 *
 * @property string $sku
 * @property string $name
 * @property Category $category
 * @property float $price
 */
class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'sku' => 'string',
        'name' => 'string',
        'category' => Category::class,
        'price' => 'float',
    ];
}
