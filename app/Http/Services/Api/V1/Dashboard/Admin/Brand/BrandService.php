<?php

namespace App\Http\Services\Api\V1\Dashboard\Admin\Brand;
use App\Http\Helpers\Http;
use App\Http\Requests\Api\V1\Dashboard\Admin\Brand\BrandRequest;
use App\Http\Requests\Api\V1\Dashboard\Admin\Brand\UpdateBrandRequest;
use App\Http\Requests\Api\V1\Dashboard\ChangeStatusRequest;
use App\Http\Resources\V1\Dashboard\Admin\Brand\BrandResource;
use App\Http\Resources\V1\Dashboard\Admin\Brand\BrandCollection;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\BrandRepositoryInterface;
use App\Http\Services\Mutual\GetService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Http\Traits\Responser;
use Illuminate\Support\Facades\DB;

class BrandService
{
    use Responser;
    protected BrandRepositoryInterface $brandRepository;
    protected GetService $getService;
    protected FileManagerService $fileManagerService;

    public function __construct(BrandRepositoryInterface $brandRepository,GetService $getService,FileManagerService $fileManagerService)
    {
        $this->getService = $getService;
        $this->brandRepository = $brandRepository;
        $this->fileManagerService = $fileManagerService;
    }

    public function index(): JsonResponse
    {
        return $this->getService->handle(BrandCollection::class,$this->brandRepository,'getAllBrands', is_instance: true, message: __('dashboard_api.show_successfully'));
    }

    public function store(BrandRequest $request): JsonResponse
    {
        try
        {
            $inputs = $request->only('image','is_active');
            if($request->hasFile('image'))
            {
                $image = $this->fileManagerService->handle("image","brands/images");
                $inputs['image'] = $image;
            }
            $brand = $this->brandRepository->create($inputs);
            $this->brandRepository->multipleLanguages($brand,$request,['name']);

            return $this->responseSuccess(Http::OK,__('messages.created successfully'),new BrandResource($brand));

        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id): JsonResponse
    {
        return $this->getService->handle(BrandResource::class , $this->brandRepository,method:'getById',parameters:[$id],is_instance:true);
    }

    public function update(UpdateBrandRequest $request,$id): JsonResponse
    {

        DB::beginTransaction();
        try
        {
            $brand = $this->brandRepository->getById($id);
            $inputs = $request->only('is_active');
            if($request->hasFile('image'))
            {
                $image = $this->fileManagerService->handle("image","brands/images",$brand->getRawOriginal('image'));
                $inputs['image'] = $image;
            }
            else
            {
                unset( $inputs['image']);
            }
            $this->brandRepository->update($brand->id,$inputs);
            $this->brandRepository->multipleLanguages($brand,$request,['name']);
            DB::commit();
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (ModelNotFoundException $exception)
        {
            DB::rollback();
            return $this->responseFail(status: Http::NOT_FOUND, message: __('messages.No data found'));
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function delete($id): JsonResponse
    {
        try
        {
            $brand = $this->brandRepository->getById($id);
            $this->fileManagerService->deleteFile($brand->image);
            $this->brandRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));

        } catch (\Exception $e) {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function changeStatus($id,ChangeStatusRequest $request): JsonResponse
    {
        $brand = $this->brandRepository->getById($id);
        $this->brandRepository->update($brand->id,['is_active' => $request->is_active]);
        return $this->responseSuccess(Http::OK,__('dashboard_api.updated_successfully'));
    }

}
