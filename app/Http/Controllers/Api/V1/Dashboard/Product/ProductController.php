<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\ChangeStatusRequest;
use App\Http\Requests\Api\V1\Dashboard\Product\StoreProductRequest;
use App\Http\Requests\Api\V1\Dashboard\Product\UpdateProductRequest;
use App\Http\Requests\Api\V1\Dashboard\Product\UpdateimageRequest;
use App\Http\Services\Api\V1\Dashboard\Product\ProductService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): JsonResponse
    {
        return $this->productService->index();
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        return $this->productService->store($request);
    }

    public function show($id): JsonResponse
    {
        return $this->productService->show($id);
    }

    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        return $this->productService->update($request,$id);
    }

    public function destroy($id): JsonResponse
    {
        return $this->productService->destroy($id);
    }

    public function changeStatus($id,ChangeStatusRequest $request): JsonResponse
    {

        return $this->productService->changeStatus($id,$request);

    }

    public function sellers(): JsonResponse
    {
        return $this->productService->sellers();

    }

    public function deleteImage($id)
    {
        return $this->productService->deleteImage($id);
    }

    public function updateImage(UpdateimageRequest $request,$id)
    {
        return $this->productService->updateImage($request,$id);
    }
}
