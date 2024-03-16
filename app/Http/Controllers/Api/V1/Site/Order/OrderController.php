<?php

namespace App\Http\Controllers\Api\V1\Site\Order;
use App\Http\Requests\Api\V1\Site\Order\OrderRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Site\Order\OrderService;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function orderCreate(OrderRequest $request)
    {
        return $this->orderService->orderCreate($request);
    }
}
