<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin\Seller;
use App\Http\Requests\Api\V1\Dashboard\Admin\Seller\SellerRequest;
use App\Http\Requests\Api\V1\Dashboard\ChangeStatusRequest;
use App\Http\Services\Api\V1\Dashboard\Admin\Seller\SellerService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class SellerDashboardController extends Controller
{
    private SellerService $sellerService;

    public function __construct(SellerService $sellerService)
    {
        $this->sellerService = $sellerService;
        $this->middleware('permission:seller-read')->only('index' , 'show');
        $this->middleware('permission:seller-create')->only('create', 'store');
        $this->middleware('permission:seller-update')->only('edit' , 'update');
        $this->middleware('permission:seller-delete')->only('destroy');
    }

    public function index()
    {
        return $this->sellerService->index();
    }

    public function create()
    {
        return $this->sellerService->create();
    }

    public function store(SellerRequest $request)
    {
        return $this->sellerService->store($request);
    }

    public function show($id)
    {
        return $this->sellerService->show($id);
    }

    public function edit($id)
    {
        return $this->sellerService->edit($id);
    }

    public function update(SellerRequest $request,$id)
    {
        return $this->sellerService->update($request,$id);
    }

    public function destroy($id)
    {
        return $this->sellerService->delete($id);
    }

    public function changeStatus($id,ChangeStatusRequest $request): JsonResponse
    {
        return $this->sellerService->changeStatus($id,$request);
    }
}
