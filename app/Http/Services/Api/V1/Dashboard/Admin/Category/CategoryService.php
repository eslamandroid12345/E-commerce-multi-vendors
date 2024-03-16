<?php

namespace App\Http\Services\Api\V1\Dashboard\Admin\Category;

use App\Http\Helpers\Http;
use App\Http\Requests\Api\V1\Dashboard\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Api\V1\Dashboard\Admin\Category\UpdateCategoryRequest;
use App\Http\Requests\Api\V1\Dashboard\ChangeStatusRequest;
use App\Http\Resources\V1\Dashboard\Admin\Category\CategoryCollection;
use App\Http\Resources\V1\Dashboard\Admin\Category\CategoryResource;
use App\Http\Resources\V1\Dashboard\Admin\Category\CategoryShowResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Repository\CategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;

class CategoryService
{
    use Responser;
    protected CategoryRepositoryInterface $categoryRepository;
    protected GetService $getService;
    protected FileManagerService $fileManagerService;
    public function __construct(CategoryRepositoryInterface $categoryRepository,FileManagerService $fileManagerService,GetService $getService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->fileManagerService = $fileManagerService;
        $this->getService = $getService;
    }

    public function getAllCategories(): JsonResponse
    {
        return $this->getService->handle(resource: CategoryCollection::class,repository: $this->categoryRepository,method: 'getAllCategories', is_instance: true, message: __('dashboard_api.show_successfully'));
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $inputs = $request->only('image','tags','is_active');

        if($request->hasFile('image'))
        {
            $image = $this->fileManagerService->handle("image","categories/images");
            $inputs['image'] = $image;
        }
        $category = $this->categoryRepository->create($inputs);
        $this->categoryRepository->multipleLanguages($category,$request,['name']);
        return $this->responseSuccess(Http::OK,__('dashboard_api.created_successfully'),new CategoryResource($category));
    }

    public function show($id): JsonResponse
    {
        return $this->getService->handle(resource: CategoryShowResource::class,repository: $this->categoryRepository,method: 'getById',parameters: [$id], is_instance: true, message: __('dashboard_api.show_successfully'));
    }

    public function update(UpdateCategoryRequest $request,$id): JsonResponse
    {
        $category = $this->categoryRepository->getById($id,['id','image','is_active']);
        $inputs = $request->only('tags','is_active');
        if($request->hasFile('image'))
        {
            $image = $this->fileManagerService->handle("image","categories/images",$category->getRawOriginal('image'));
            $inputs['image'] = $image;
        }
        $this->categoryRepository->update($category->id,$inputs);
        $this->categoryRepository->multipleLanguages($category,$request,['name']);
        return $this->responseSuccess(Http::OK,__('dashboard_api.updated_successfully'));
    }

    public function destroy($id): JsonResponse
    {
        $this->categoryRepository->delete($id);
        return $this->responseSuccess(Http::OK,__('dashboard_api.deleted_successfully'));
    }

    public function changeStatus($id,ChangeStatusRequest $request): JsonResponse
    {
       $category = $this->categoryRepository->getById($id);
       $this->categoryRepository->update($category->id,['is_active' => $request->is_active]);
        return $this->responseSuccess(Http::OK,__('dashboard_api.updated_successfully'));
    }

}
