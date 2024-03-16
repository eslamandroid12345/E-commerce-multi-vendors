<?php

namespace App\Http\Services\Api\V1\Dashboard\Order;
use App\Http\Requests\Api\V1\Dashboard\Order\OrderChangeStatusRequest;
use App\Http\Resources\V1\Dashboard\Order\OrderCollection;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\Responser;
use App\Http\Services\Mutual\GetService;
use Illuminate\Http\JsonResponse;
use App\Repository\OrderRepositoryInterface;
use App\Repository\OrderDetailRepositoryInterface;
use App\Http\Resources\V1\Dashboard\Order\OrderResource;
use App\Http\Resources\V1\Dashboard\Order\OneOrderResource;
use App\Http\Requests\Api\V1\Dashboard\Admin\Order\FilterOrderRequest;

class OrderService
{
    protected OrderRepositoryInterface $orderRepository;
    protected OrderDetailRepositoryInterface $orderDetailRepository;
    protected FileManagerService $fileManagerService;
    protected GetService $getService;

    use Responser;

    public function __construct(OrderRepositoryInterface $orderRepository, OrderDetailRepositoryInterface $orderDetailRepository, GetService $getService,FileManagerService $fileManagerService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->getService = $getService;
        $this->fileManagerService = $fileManagerService;
    }

    public function  getAllOrders(): JsonResponse
    {
        if(auth('admin-api')->user()->user_type == 'admin')
        {
            return $this->getService->handle(OrderCollection::class,$this->orderRepository,'getAllOrders', is_instance: true, message: __('dashboard_api.show_successfully'));
        }
        else
        {
            return $this->getService->handle(OrderCollection::class,$this->orderRepository,'getOrdersSeller',parameters: [auth('admin-api')->id()], is_instance: true, message: __('dashboard_api.show_successfully'));
        }
    }

    public function  getOneOrder($id): JsonResponse
    {
        return $this->getService->handle(OneOrderResource::class, $this->orderRepository, 'getById', parameters: [$id], is_instance: true, message: __('dashboard_api.show_successfully'));
    }

    public function filterOrder(FilterOrderRequest $request): JsonResponse
    {
        return $this->getService->handle(OrderResource::class, $this->orderRepository, 'filter', parameters: [$request->category_id, $request->brand_id, $request->status, $request->placed_date, $request->payment_gateway, $request->price_from, $request->price_to], is_instance: true, message: __('dashboard_api.show_successfully'));

    }

    public function changeStatus($id,OrderChangeStatusRequest $request): JsonResponse
    {
        $order = $this->orderRepository->getById($id);
        $this->orderRepository->update($order->id,['order_status' => $request->order_status]);
        return $this->responseSuccess(200,__('dashboard_api.updated_successfully'));
    }
}

