<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\Feature\FeatureRequest;
use App\Http\Requests\Api\V1\Dashboard\Feature\UpdateProductFeaturesRequest;
use App\Http\Services\Api\V1\Dashboard\Admin\ProductFeature\ProductFeatureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeatureProductController extends Controller
{
    protected ProductFeatureService $productFeatureService;

    public function __construct(ProductFeatureService $productFeatureService)
    {
        $this->productFeatureService = $productFeatureService;
    }

    public function addFeature($id,FeatureRequest $request): JsonResponse
    {
        return $this->productFeatureService->addFeature($id,$request);
    }

    public function getAllFeatures($id): JsonResponse
    {
        return  $this->productFeatureService->getAllFeatures($id);
    }

    public function updateFeatures($id,UpdateProductFeaturesRequest $request)
    {
        return $this->productFeatureService->updateFeatures($id,$request);
    }

    public function deleteFeature($id): JsonResponse
    {
        return $this->productFeatureService->deleteFeature($id);
    }

}
