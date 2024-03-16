<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\ChangeStatusRequest;
use App\Http\Services\Api\V1\Dashboard\Admin\User\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {

        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {

        return $this->userService->getAllCustomers();
    }


    public function show($id): JsonResponse
    {

        return $this->userService->show($id);
    }

    public function destroy($id): JsonResponse
    {
        return $this->userService->destroy($id);
    }


    public function changeStatus($id,ChangeStatusRequest $request): JsonResponse
    {

        return $this->userService->changeStatus($id,$request);

    }
}
