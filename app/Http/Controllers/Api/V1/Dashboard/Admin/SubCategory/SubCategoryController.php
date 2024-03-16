<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin\SubCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\Admin\SubCategory\StoreSubCategoryRequest;
use App\Http\Requests\Api\V1\Dashboard\Admin\SubCategory\UpdateSubCategoryRequest;
use App\Http\Requests\Api\V1\Dashboard\ChangeStatusRequest;
use App\Http\Services\Api\V1\Dashboard\Admin\SubCategory\SubCategoryService;
use Illuminate\Http\JsonResponse;

class SubCategoryController extends Controller
{
    protected SubCategoryService $subCategoryService;

    public function __construct(SubCategoryService $subCategoryService)
    {
        $this->subCategoryService = $subCategoryService;
        $this->middleware('permission:subcategory-read')->only('index' , 'show');
        $this->middleware('permission:subcategory-create')->only('create', 'store');
        $this->middleware('permission:subcategory-update')->only('edit' , 'update');
        $this->middleware('permission:subcategory-delete')->only('destroy');
    }


    public function index(): JsonResponse
    {

        return $this->subCategoryService->getAllSubCategories();
    }


    public function store(StoreSubCategoryRequest $request): JsonResponse
    {


        return $this->subCategoryService->store($request);

    }


    public function show($id): JsonResponse
    {

        return $this->subCategoryService->show($id);

    }


    public function update(UpdateSubCategoryRequest $request,$id): JsonResponse
    {

        return $this->subCategoryService->update($request,$id);

    }


    public function destroy($id): JsonResponse
    {

        return $this->subCategoryService->destroy($id);

    }

    public function changeStatus($id,ChangeStatusRequest $request): JsonResponse
    {

        return $this->subCategoryService->changeStatus($id,$request);

    }
}
