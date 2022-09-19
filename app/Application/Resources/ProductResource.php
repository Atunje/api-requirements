<?php

namespace App\Application\Resources;

use App\Domain\Products\Actions\CreatePriceDetailsAction;
use App\Domain\Products\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->name,
            'category' => $this->category,
            'price' => $this->getPriceDetails(),
        ];
    }

    private function getPriceDetails(): array
    {
        $action = new CreatePriceDetailsAction($this->resource);
        return $action();
    }
}
