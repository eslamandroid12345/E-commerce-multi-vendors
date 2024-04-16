<?php

namespace App\Http\Controllers\Api\V1\Dashboard\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Dashboard\Admin\Auth\LoginRequest;
use App\Http\Services\Api\V1\Dashboard\Admin\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {

        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {

        return $this->authService->login($request);
    }

    public function getProfile(): JsonResponse
    {

        return $this->authService->getProfile();
    }

    public function home(): JsonResponse
    {

        return $this->authService->home();

    }

    public function logout(): JsonResponse
    {

        return $this->authService->logout();
    }
}
