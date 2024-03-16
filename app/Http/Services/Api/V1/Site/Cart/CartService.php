<?php

namespace App\Http\Services\Api\V1\Site\Cart;
use App\Http\Resources\V1\Dashboard\Admin\Brand\BrandCollection;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\Responser;
use App\Http\Services\Mutual\GetService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\V1\Site\Cart\CartRequest;
use App\Repository\ProductFeatureItemRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Repository\CartRepositoryInterface;
use App\Http\Resources\V1\Site\Cart\CartResource;

class CartService
{
    protected CartRepositoryInterface $cartRepository;
    protected ProductFeatureItemRepositoryInterface $productfeatureitemRepository;
    protected ProductRepositoryInterface $productRepository;
    protected FileManagerService $fileManagerService;
    protected GetService $getService;

    use Responser;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        ProductFeatureItemRepositoryInterface $productfeatureitemRepository,
        ProductRepositoryInterface $productRepository,
        GetService $getService,
        FileManagerService $fileManagerService)
    {
        $this->cartRepository = $cartRepository;
        $this->productfeatureitemRepository = $productfeatureitemRepository;
        $this->productRepository = $productRepository;
        $this->getService = $getService;
        $this->fileManagerService = $fileManagerService;
    }

    public function addToCart(CartRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $data = $request->only('product_feature_item_id','quantity','user_id');
            $cart = $this->cartRepository->create($data);
            DB::commit();
            return $this->responseSuccess(200, __('messages.created successfully'), new CartResource($cart));
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function updateItemCart($id,CartRequest $request)
    {
        try
        {
            $data = $request->only('product_feature_item_id','quantity','user_id');
            $cart = $this->cartRepository->getById($id);
            $this->cartRepository->update($cart->id,$data);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function deleteFromCart($id)
    {
        try
        {
            $cart = $this->cartRepository->getById($id);
            $this->cartRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));

        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function deleteAllFromCart(Request $request)
    {
        try
        {
            if($request->delete_ids)
            {
                foreach(json_decode($request->delete_ids, true) as $id)
                {
                    $cart = $this->cartRepository->getById($id);
                    $this->cartRepository->delete($id);
                }
            }
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function getAllItems()
    {
        return $this->getService->handle(CartResource::class,$this->cartRepository, message: __('dashboard_api.show_successfully'));
    }
}
