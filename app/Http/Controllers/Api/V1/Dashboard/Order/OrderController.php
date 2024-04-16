<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Order;
use App\Http\Requests\Api\V1\Dashboard\Admin\Order\FilterOrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\Order\OrderChangeStatusRequest;
use App\Http\Services\Api\V1\Dashboard\Order\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function getAllOrders(): JsonResponse
    {
        return $this->orderService->getAllOrders();
    }

    public function getOneOrder($id): JsonResponse
    {
        return $this->orderService->getOneOrder($id);
    }
    public function filterOrder(FilterOrderRequest $request): JsonResponse
    {
        return $this->orderService->filterOrder($request);
    }
    public function changeStatus($id,OrderChangeStatusRequest $request): JsonResponse
    {
        return $this->orderService->changeStatus($id,$request);
    }
}
