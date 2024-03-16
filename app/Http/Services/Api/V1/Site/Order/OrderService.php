<?php

namespace App\Http\Services\Api\V1\Site\Order;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\Responser;
use App\Http\Services\Mutual\GetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\V1\Site\Order\OrderRequest;
use App\Repository\OrderRepositoryInterface;
use App\Repository\OrderDetailRepositoryInterface;
use App\Repository\ProductFeatureItemRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Http\Resources\V1\Site\Order\OrderResource;

class OrderService
{
    protected OrderRepositoryInterface $orderRepository;
    protected OrderDetailRepositoryInterface $orderdetailsRepository;
    protected ProductFeatureItemRepositoryInterface $productfeatureitemRepository;
    protected ProductRepositoryInterface $productRepository;
    protected FileManagerService $fileManagerService;
    protected GetService $getService;

    use Responser;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderDetailRepositoryInterface $orderdetailsRepository,
        ProductFeatureItemRepositoryInterface $productfeatureitemRepository,
        ProductRepositoryInterface $productRepository,
        GetService $getService,
        FileManagerService $fileManagerService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderdetailsRepository = $orderdetailsRepository;
        $this->productfeatureitemRepository = $productfeatureitemRepository;
        $this->productRepository = $productRepository;
        $this->getService = $getService;
        $this->fileManagerService = $fileManagerService;
    }

    public function orderCreate(OrderRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $data = array_merge($request->only('payment_method','payment_gateway','user_id'),['grand_total' => 0]);
            $order = $this->orderRepository->create($data);
            if(is_array($request->orderdetails))
            {
                $sum_total = 0;
                foreach($request->orderdetails as $details)
                {
                    $productFeatureItem = $this->productfeatureitemRepository->getById($details['product_feature_item_id']);
                    $product = $this->productRepository->getById($productFeatureItem->product_id);
                    $order_details = [
                                        'order_id' => $order->id,
                                        'product_feature_item_id' => $details['product_feature_item_id'],
                                        'item_price' => $productFeatureItem->price,
                                        'quantity' => $details['quantity'],
                                        'seller_id' => $product->seller_id,
                                    ];
                    $order_details = $this->orderdetailsRepository->create($order_details);
                    $sum_total = $sum_total + ($productFeatureItem->price * $details['quantity']);
                }
            }
//            $this->orderRepository->update($order->id,['grand_total' => $sum_total]);
            $order->update(['grand_total' => $sum_total]);
            DB::commit();
            return $this->responseSuccess(200, __('messages.created successfully'), new OrderResource($order));
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
