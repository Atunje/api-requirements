<?php

namespace App\Application\Controllers;

use App\Application\Requests\ProductsRequest;
use App\Application\Resources\ProductResource;
use App\Domain\Products\Repositories\ProductRepository;
use App\Infrastructure\Laravel\Controller;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
        //
    }

    public function index(ProductsRequest $request): JsonResponse
    {
        $products = $this->productRepository->findAll($request->filterParams());
        $collection = ProductResource::collection($products)->resource;

        return response()->json(['status' => 1, 'products' => $collection]);
    }
}
