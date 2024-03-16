<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Seller;
use App\Http\Requests\Api\V1\Dashboard\Seller\SellerRequest;
use App\Http\Controllers\Controller;
use App\Http\Services\Api\V1\Dashboard\Seller\SellerService;

class SellerController extends Controller
{
    private SellerService $sellerService;

    public function __construct(SellerService $sellerService)
    {
        $this->sellerService = $sellerService;
    }

    public function register(SellerRequest $request)
    {
        return $this->sellerService->register($request);
    }
}
