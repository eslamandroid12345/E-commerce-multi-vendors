<?php

namespace App\Http\Services\Api\V1\Dashboard\Admin\ProductFeature;
use App\Http\Helpers\Http;
use App\Http\Requests\Api\V1\Dashboard\Feature\FeatureRequest;
use App\Http\Requests\Api\V1\Dashboard\Feature\UpdateProductFeaturesRequest;
use App\Http\Resources\V1\Dashboard\Admin\Feature\FeatureResource;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Repository\ProductFeatureDetailRepositoryInterface;
use App\Repository\ProductFeatureItemDetailRepositoryInterface;
use App\Repository\ProductFeatureItemRepositoryInterface;
use App\Repository\ProductFeatureRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductFeatureService
{

    use Responser;

    protected ProductFeatureRepositoryInterface $productFeatureRepository;

    protected ProductRepositoryInterface $productRepository;

    protected ProductFeatureDetailRepositoryInterface $productFeatureDetailRepository;
    protected ProductFeatureItemRepositoryInterface $productFeatureItemRepository;

    protected ProductFeatureItemDetailRepositoryInterface $productFeatureItemDetailRepository;

    protected GetService $getService;
    public function __construct(GetService $getService,ProductFeatureRepositoryInterface $productFeatureRepository,ProductRepositoryInterface $productRepository,ProductFeatureDetailRepositoryInterface $productFeatureDetailRepository, ProductFeatureItemRepositoryInterface $productFeatureItemRepository,ProductFeatureItemDetailRepositoryInterface $productFeatureItemDetailRepository)
    {

        $this->getService = $getService;
        $this->productFeatureRepository = $productFeatureRepository;
        $this->productRepository = $productRepository;
        $this->productFeatureDetailRepository = $productFeatureDetailRepository;
        $this->productFeatureItemRepository = $productFeatureItemRepository;
        $this->productFeatureItemDetailRepository = $productFeatureItemDetailRepository;
    }


    public function addFeature($id,FeatureRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $product = $this->productRepository->getById($id);

            if($product->count_orders > 0){

                return $this->responseFail(Http::FORBIDDEN, __('messages.forbidden_add_new_feature'));
            }

            foreach ($request->productFeature as $feature) {
                $productFeature = $this->productFeatureRepository->createProductFeature($product,$feature);
                $this->createProductFeatureDetails($productFeature,$feature);
            }
            $this->storePrices($product);
            $this->addFeaturesToPrice($product);
            DB::commit();
            return $this->responseSuccess(Http::OK, __('messages.message_check_prices_add'));
        }
        catch (ModelNotFoundException $exception) {
            DB::rollback();
            return $this->responseFail(Http::NOT_FOUND, __('messages.No data found'));
        }
        catch (\Exception $e) {
            DB::rollback();
            return $this->responseFail(Http::INTERNAL_SERVER_ERROR,$e->getMessage());
        }
    }


    protected function createProductFeatureDetails($productFeature,$featureData): void
    {
        foreach ($featureData['details']['content'] as $detail) {

            $this->productFeatureDetailRepository->create(['product_feature_id' => $productFeature->id, 'content' => $detail]);

        }
    }


    protected function storePrices($product): bool
    {

        $oldProductFeatureItems = $this->productFeatureItemRepository->getProductFeatureItems($product);//Get all old prices of product

        foreach ($oldProductFeatureItems as $oldProductFeatureItem){

            $this->productFeatureItemRepository->delete($oldProductFeatureItem->id);//delete old prices when add new feature
        }

        $productFeatureQuantities = $this->productFeatureRepository->productFeaturesWithQuantities($product);//[2,2,2]

        $totalQuantity = array_product($productFeatureQuantities);//2*2*2


        $productFeatureItems = [];
        for ($i = 0; $i < $totalQuantity; $i++) {
            $productFeatureItems[] = [
                'product_id' => $product->id,
                'product_price' => 0,
                'price' => 0,
                'quantity' => 0
            ];
        }

        return $this->productFeatureItemRepository->createMany($productFeatureItems);//create many prices
    }


    public function addFeaturesToPrice($product): void
    {

        $productFeatures = $this->productFeatureRepository->productFeaturesWithDetails($product);

        $arrays = [];

        foreach ($productFeatures as $productFeature) {
            $arrays[] = $productFeature->details->pluck('id');
        }

        $result = $this->nestedLoop($arrays);


        $productFeatureItems = $this->productFeatureItemRepository->getProductFeatureItems($product);

        foreach ($productFeatureItems as $key => $item) {
            foreach ($result[$key] as $rslt) {

                $this->productFeatureItemDetailRepository->create(['product_feature_item_id' => $item->id, 'product_feature_detail_id' => $rslt]);

            }
        }
    }


    protected function nestedLoop($arrays, $currentIndex = 0, $currentArray = []): array
    {
        $result = [];

        if ($currentIndex == count($arrays)) {
            return [$currentArray];
        }

        foreach ($arrays[$currentIndex] as $value) {
            $currentArray[$currentIndex] = $value;
            $result = array_merge($result, $this->nestedLoop($arrays, $currentIndex+1, $currentArray));
        }
        return $result;
    }


    public function getAllFeatures($id): JsonResponse
    {
        try {

            $product = $this->productRepository->getById($id);
            $features = $this->productFeatureRepository->getAllFeaturesByProductId($product->id);

            return $this->responseSuccess(Http::OK, __('dashboard_api.show_successfully'),FeatureResource::collection($features));

        } catch (ModelNotFoundException $exception) {
            return $this->responseFail(Http::NOT_FOUND, __('messages.No data found'));
        } catch (\Exception $e) {
            return $this->responseFail(Http::INTERNAL_SERVER_ERROR,$e->getMessage());
        }
    }



    public function updateFeatures($id,UpdateProductFeaturesRequest $request): JsonResponse
    {

        DB::beginTransaction();
        try {

            $product = $this->productRepository->getById($id);

            foreach ($request->productFeature as $feature) {
                $this->productFeatureRepository->updateProductFeature($product,$feature);
                $this->updateProductFeatureDetails($feature);
            }

            DB::commit();

            return $this->responseSuccess(Http::OK, __('messages.updated successfully'));

        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return $this->responseFail(Http::NOT_FOUND, __('messages.No data found'));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->responseFail(Http::INTERNAL_SERVER_ERROR,$e->getMessage());
        }

    }


    protected function updateProductFeatureDetails($featureData): void
    {
        foreach ($featureData['details'] as $detail)
        {
            $this->productFeatureDetailRepository->update($detail['id'],['content' => $detail['content']]);
        }
    }

    public function deleteFeature($id): JsonResponse
    {

        try {

            $productFeature = $this->productFeatureRepository->getById($id);
            $product = $this->productRepository->getById($productFeature->product_id);

            if($product->count_orders > 0){
                return $this->responseFail(Http::FORBIDDEN, __('messages.forbidden_delete_feature'));
            }

            $this->productFeatureRepository->delete($productFeature->id);

            $oldProductFeatureItems = $this->productFeatureItemRepository->getProductFeatureItems($product);//Get all old prices of product

            foreach ($oldProductFeatureItems as $oldProductFeatureItem){

                $this->productFeatureItemRepository->delete($oldProductFeatureItem->id);//delete old prices when delete feature
            }

            return $this->responseSuccess(Http::OK, __('messages.message_check_prices_delete'));

        } catch (ModelNotFoundException $exception) {
            return $this->responseFail(Http::NOT_FOUND, __('messages.No data found'));
        } catch (\Exception $e) {
            return $this->responseFail(Http::INTERNAL_SERVER_ERROR,$e->getMessage());
        }


    }

}
