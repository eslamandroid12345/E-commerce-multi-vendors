<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin\Brand;
use App\Http\Requests\Api\V1\Dashboard\Admin\Brand\BrandRequest;
use App\Http\Requests\Api\V1\Dashboard\Admin\Brand\UpdateBrandRequest;
use App\Http\Requests\Api\V1\Dashboard\ChangeStatusRequest;
use App\Http\Services\Api\V1\Dashboard\Admin\Brand\BrandService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
    private BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
        $this->middleware('permission:brand-read')->only('index' , 'show');
        $this->middleware('permission:brand-create')->only('create', 'store');
        $this->middleware('permission:brand-update')->only('edit' , 'update');
        $this->middleware('permission:brand-delete')->only('destroy');
    }

    public function index()
    {
        return $this->brandService->index();
    }

    public function create()
    {
        return $this->brandService->create();
    }

    public function store(BrandRequest $request): JsonResponse
    {
        return $this->brandService->store($request);
    }

    public function show($id): JsonResponse
    {
        return $this->brandService->show($id);
    }

    public function edit($id)
    {
        return $this->brandService->edit($id);
    }

    public function update(UpdateBrandRequest $request,$id): JsonResponse
    {
        return $this->brandService->update($request,$id);
    }

    public function destroy($id): JsonResponse
    {
        return $this->brandService->delete($id);
    }

    public function changeStatus($id,ChangeStatusRequest $request): JsonResponse
    {
        return $this->brandService->changeStatus($id,$request);
    }
}
