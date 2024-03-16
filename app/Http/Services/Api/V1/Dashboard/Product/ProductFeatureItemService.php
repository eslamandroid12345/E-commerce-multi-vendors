<?php

namespace App\Http\Services\Api\V1\Dashboard\Product;

use App\Http\Helpers\Http;
use App\Http\Requests\Api\V1\Dashboard\Product\ProductFeatureItemRequest;
use App\Http\Resources\V1\Dashboard\Product\ProductFeatureItemResource;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Repository\ProductFeatureItemRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductFeatureItemService
{

    use Responser;

    protected ProductFeatureItemRepositoryInterface $productFeatureItemRepository;
    protected GetService $getService;

    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductFeatureItemRepositoryInterface $productFeatureItemRepository,GetService $getService,ProductRepositoryInterface $productRepository)
    {
        $this->productFeatureItemRepository = $productFeatureItemRepository;
        $this->getService = $getService;
        $this->productRepository = $productRepository;
    }

    public function getAllPrices($id): JsonResponse
    {
        $product = $this->productRepository->getById($id);
        return $this->getService->handle(ProductFeatureItemResource::class, $this->productFeatureItemRepository,'get',['product_id',$product->id],message: __('dashboard_api.show_successfully'));
    }

    public function updateAllPrices($id,ProductFeatureItemRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $this->productRepository->getById($id);
            foreach ($request->prices as $price)
            {
                $productFeatureItem = $this->productFeatureItemRepository->getById($price['id']);
                $this->productFeatureItemRepository->update($productFeatureItem->id, [
                    'product_price' => $price['product_price'],
                    'price' => $price['price'],
                    'discount' => $price['discount'],
                    'quantity' => $price['quantity']
                ]);
            }
            DB::commit();
            return $this->responseSuccess(Http::OK, __('messages.updated successfully'));
        }
        catch (ModelNotFoundException $exception)
        {
            DB::rollback();
            return $this->responseFail(status: Http::NOT_FOUND, message: __('messages.No data found'));
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

}
