<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\SignInRequest;
use App\Http\Requests\Api\V1\Auth\SignUpRequest;
use App\Http\Services\Api\V1\Auth\AuthService;

class AuthController extends Controller
{

    protected AuthService $authService;


    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function signUp(SignUpRequest $request) {
        return $this->authService->signUp($request);
    }

    public function signIn(SignInRequest $request) {
        return $this->authService->signIn($request);
    }

    public function signOut()
    {
        return $this->authService->signOut();
    }

    public function whatIsMyPlatform()
    {
        return $this->authService->whatIsMyPlatform();
    }
}
