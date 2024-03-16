<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Api\V1\Dashboard\Admin\Category\UpdateCategoryRequest;
use App\Http\Requests\Api\V1\Dashboard\ChangeStatusRequest;
use App\Http\Services\Api\V1\Dashboard\Admin\Category\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{

    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->middleware('permission:category-read')->only('index' , 'show');
        $this->middleware('permission:category-create')->only('create', 'store');
        $this->middleware('permission:category-update')->only('edit' , 'update');
        $this->middleware('permission:category-delete')->only('destroy');
    }


    public function index(): JsonResponse
    {

        return $this->categoryService->getAllCategories();

    }


    public function store(StoreCategoryRequest $request): JsonResponse
    {

        return $this->categoryService->store($request);

    }


    public function show($id): JsonResponse
    {

        return $this->categoryService->show($id);

    }


    public function update(UpdateCategoryRequest $request,$id): JsonResponse
    {

        return $this->categoryService->update($request,$id);

    }


    public function destroy($id): JsonResponse
    {

        return $this->categoryService->destroy($id);

    }

    public function changeStatus($id,ChangeStatusRequest $request): JsonResponse
    {

        return $this->categoryService->changeStatus($id,$request);

    }
}
