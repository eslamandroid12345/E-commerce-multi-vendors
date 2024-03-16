<?php

namespace App\Http\Services\Api\V1\Dashboard\Admin\Seller;
use App\Http\Requests\Api\V1\Dashboard\Admin\Seller\SellerRequest;
use App\Http\Requests\Api\V1\Dashboard\ChangeStatusRequest;
use App\Http\Resources\V1\Dashboard\Admin\Seller\SellerResource;
use App\Http\Resources\V1\Dashboard\Admin\Seller\SellerCollection;
use App\Http\Services\Mutual\FileManagerService;
use App\Repository\AuthRepositoryInterface;
use App\Http\Services\Mutual\GetService;
use Illuminate\Http\JsonResponse;
use App\Http\Traits\Responser;
use Illuminate\Support\Facades\Hash;

class SellerService
{
    use Responser;
    protected AuthRepositoryInterface $sellerRepository;
    protected GetService $getService;
    protected FileManagerService $fileManagerService;

    public function __construct(AuthRepositoryInterface $sellerRepository,GetService $getService,FileManagerService $fileManagerService)
    {
        $this->getService = $getService;
        $this->sellerRepository = $sellerRepository;
        $this->fileManagerService = $fileManagerService;
    }

    public function index(): JsonResponse
    {
        return $this->getService->handle(SellerCollection::class,$this->sellerRepository,'getAllSellers', is_instance: true, message: __('dashboard_api.show_successfully'));
    }

    public function store(SellerRequest $request): JsonResponse
    {
        try
        {
            $inputs = $request->except('password_confirmation');
            if($request->hasFile('image'))
            {
                $image = $this->fileManagerService->handle("image","sellers/images");
                $inputs['image'] = $image;
            }
            $is_active = $request->is_active ? 1 : 0;
            $inputs['password'] = Hash::make( $inputs['password']);
            $inputs['is_active'] = $is_active;
            $seller = $this->sellerRepository->create($inputs);
            return $this->responseSuccess(200,__('messages.created successfully'),new SellerResource($seller));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function show($id): JsonResponse
    {
        return $this->getService->handle(SellerResource::class , $this->sellerRepository,method:'getById',parameters:[$id],is_instance:true);
    }

    public function update(SellerRequest $request, $id): JsonResponse
    {
        try
        {
            $seller = $this->sellerRepository->getById($id);
            $inputs = $request->except('password_confirmation');
            if($request->hasFile('image'))
            {
                $this->fileManagerService->deleteFile($seller->image);
                $image = $this->fileManagerService->handle("image","sellers/images",$seller->getRawOriginal('image'));
                $inputs['image'] = $image;
            }
            else
            {
                unset( $inputs['image']);
            }
            if($request->password)
            {
                $inputs['password'] = Hash::make( $inputs['password']);
            }
            $this->sellerRepository->update($id,$inputs);
            return $this->responseSuccess(message: __('messages.updated successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function delete($id): JsonResponse
    {
        try
        {
            $seller = $this->sellerRepository->getById($id);
            $this->fileManagerService->deleteFile($seller->image);
            $this->sellerRepository->delete($id);
            return $this->responseSuccess(message: __('messages.deleted successfully'));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function changeStatus($id,ChangeStatusRequest $request): JsonResponse
    {
        $seller = $this->sellerRepository->getById($id);
        $this->sellerRepository->update($seller->id,['is_active' => $request->is_active]);
        return $this->responseSuccess(200,__('dashboard_api.updated_successfully'));
    }
}
