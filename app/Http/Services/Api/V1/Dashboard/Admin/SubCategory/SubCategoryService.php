<?php

namespace App\Http\Services\Api\V1\Dashboard\Admin\SubCategory;
use App\Http\Helpers\Http;
use App\Http\Requests\Api\V1\Dashboard\Admin\SubCategory\StoreSubCategoryRequest;
use App\Http\Requests\Api\V1\Dashboard\Admin\SubCategory\UpdateSubCategoryRequest;
use App\Http\Requests\Api\V1\Dashboard\ChangeStatusRequest;
use App\Http\Resources\V1\Dashboard\Admin\SubCategory\SubCategoryCollection;
use App\Http\Resources\V1\Dashboard\Admin\SubCategory\SubCategoryResource;
use App\Http\Resources\V1\Dashboard\Admin\SubCategory\SubCategoryShowResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Repository\SubCategoryRepositoryInterface;
use Illuminate\Http\JsonResponse;

class SubCategoryService
{
    use Responser;

    protected SubCategoryRepositoryInterface $subCategoryRepository;
    protected FileManagerService $fileManagerService;

    protected GetService $getService;

    public function __construct(SubCategoryRepositoryInterface $subCategoryRepository,FileManagerService $fileManagerService,GetService $getService)
    {
        $this->subCategoryRepository = $subCategoryRepository;
        $this->fileManagerService = $fileManagerService;
        $this->getService = $getService;
    }


    public function getAllSubCategories(): JsonResponse
    {

        return $this->getService->handle(SubCategoryCollection::class,$this->subCategoryRepository,'getAllSubCategories', is_instance: true, message: __('dashboard_api.show_successfully'));

    }


    public function store(StoreSubCategoryRequest $request): JsonResponse
    {

        $inputs = $request->only('tags','category_id','is_active');

        if($request->hasFile('image')){

            $image = $this->fileManagerService->handle("image","sub_categories/images");
            $inputs['image'] = $image;

        }
        $subCategory = $this->subCategoryRepository->create($inputs);
        $this->subCategoryRepository->multipleLanguages($subCategory,$request,['name']);


        return $this->responseSuccess(Http::OK,__('dashboard_api.created_successfully'),new SubCategoryResource($subCategory));

    }


    public function show($id): JsonResponse
    {
        return $this->getService->handle(SubCategoryShowResource::class,$this->subCategoryRepository,'getById',[$id], is_instance: true, message: __('dashboard_api.show_successfully'));

    }


    public function update(UpdateSubCategoryRequest $request,$id): JsonResponse
    {
        $subCategory = $this->subCategoryRepository->getById($id,['id','image','is_active']);
        $inputs = $request->only('tags','category_id','is_active');

        if($request->hasFile('image')){

            $image = $this->fileManagerService->handle("image","sub_categories/images",$subCategory->getRawOriginal('image'));
            $inputs['image'] = $image;

        }
        $this->subCategoryRepository->update($subCategory->id,$inputs);
        $this->subCategoryRepository->multipleLanguages($subCategory,$request,['name']);

        return $this->responseSuccess(Http::OK,__('dashboard_api.updated_successfully'));

    }


    public function destroy($id): JsonResponse
    {
        $this->subCategoryRepository->delete($id);

        return $this->responseSuccess(Http::OK,__('dashboard_api.deleted_successfully'));

    }

    public function changeStatus($id,ChangeStatusRequest $request): JsonResponse
    {
        $subCategory = $this->subCategoryRepository->getById($id);

        $this->subCategoryRepository->update($subCategory->id,['is_active' => $request->is_active]);

        return $this->responseSuccess(Http::OK,__('dashboard_api.updated_successfully'));

    }

}
