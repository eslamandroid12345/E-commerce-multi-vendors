<?php

namespace App\Http\Services\Api\V1\Dashboard\Admin\User;

use App\Http\Helpers\Http;
use App\Http\Requests\Api\V1\Dashboard\ChangeStatusRequest;
use App\Http\Resources\V1\Dashboard\Admin\User\UserCollection;
use App\Http\Resources\V1\Dashboard\Admin\User\UserResource;
use App\Http\Resources\V1\Dashboard\Admin\User\UserShowResource;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;

class UserService
{
    use Responser;
    protected UserRepositoryInterface $userRepository;
    protected GetService $getService;
    public function __construct(UserRepositoryInterface $userRepository,GetService $getService)
    {
        $this->userRepository = $userRepository;
        $this->getService = $getService;
    }

    public function getAllCustomers(): JsonResponse
    {
        return $this->getService->handle(UserCollection::class,$this->userRepository,'getAllCustomers', is_instance: true, message: __('dashboard_api.show_successfully'));
    }

    public function show($id): JsonResponse
    {
        return $this->getService->handle(UserShowResource::class,$this->userRepository,'getById',parameters: [$id], is_instance: true, message: __('dashboard_api.show_successfully'));
    }

    public function destroy($id): JsonResponse
    {
        $this->userRepository->delete($id);
        return $this->responseSuccess(Http::OK,__('dashboard_api.deleted_successfully'));
    }

    public function changeStatus($id,ChangeStatusRequest $request): JsonResponse
    {
        $user = $this->userRepository->getById($id);
        $this->userRepository->update($user->id,['is_active' => $request->is_active]);
        return $this->responseSuccess(Http::OK,__('dashboard_api.updated_successfully'));
    }

}
