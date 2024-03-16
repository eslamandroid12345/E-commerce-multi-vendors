<?php

namespace App\Http\Services\Api\V1\Dashboard\Seller;
use App\Http\Helpers\Http;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Traits\Responser;
use App\Http\Services\Mutual\GetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repository\AuthRepositoryInterface;
use App\Http\Requests\Api\V1\Dashboard\Seller\SellerRequest;
use App\Http\Resources\V1\Dashboard\Admin\Auth\AdminResource;

class SellerService
{
    protected AuthRepositoryInterface $authRepository;

    protected FileManagerService $fileManagerService;
    protected GetService $getService;

    use Responser;

    public function __construct(AuthRepositoryInterface $authRepository,GetService $getService,FileManagerService $fileManagerService)
    {
        $this->authRepository = $authRepository;
        $this->getService = $getService;
        $this->fileManagerService = $fileManagerService;
    }

    public function register(SellerRequest $request): JsonResponse
    {
        try
        {
            $inputs = $request->validated();

            $inputs['password'] = Hash::make( $inputs['password']);

            if($request->hasFile('image'))
            {
                $image = $this->fileManagerService->handle("image","admins/images");
                $inputs['image'] = $image;
            }

            $seller = $this->authRepository->create($inputs);
            $token = auth('admin-api')->attempt($request->only('email', 'password'));
            $auth = Auth::guard('admin-api')->user();
            $auth['token'] = $token;
            $seller->roles()->attach(4);
            return $this->responseSuccess(Http::OK,__('messages.created successfully'),new AdminResource($auth));
        }
        catch (\Exception $e)
        {
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
