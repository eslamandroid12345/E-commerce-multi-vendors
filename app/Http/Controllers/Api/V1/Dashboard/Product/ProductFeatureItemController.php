<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\Product\ProductFeatureItemRequest;
use App\Http\Services\Api\V1\Dashboard\Product\ProductFeatureItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductFeatureItemController extends Controller
{

    protected ProductFeatureItemService $productFeatureItemService;

    public function __construct(ProductFeatureItemService $productFeatureItemService)
    {
        $this->productFeatureItemService = $productFeatureItemService;
    }

    public function getAllPrices($id): JsonResponse
    {
        return $this->productFeatureItemService->getAllPrices($id);
    }

    public function updateAllPrices($id,ProductFeatureItemRequest $request): JsonResponse
    {
        return $this->productFeatureItemService->updateAllPrices($id,$request);
    }


}
