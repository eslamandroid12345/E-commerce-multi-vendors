<?php

namespace App\Http\Services\Api\V1\Dashboard\Admin\Auth;

use App\Http\Helpers\Http;
use App\Http\Requests\Api\V1\Dashboard\Admin\Auth\LoginRequest;
use App\Http\Resources\V1\Dashboard\Admin\Auth\AdminResource;
use App\Http\Resources\V1\Dashboard\Admin\Home\HomeResource;
use App\Http\Traits\Responser;
use App\Repository\AuthRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthService
{

    use Responser;
    protected AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try
        {
            $token = auth('admin-api')->attempt($request->only('email', 'password'));

            if (!$token)
            {
                return $this->responseFail(Http::UNAUTHORIZED,  __('auth_api.failed_message'));
            }
            $auth = Auth::guard('admin-api')->user();
            $auth['token'] = $token;

            return $this->responseSuccess(Http::OK,__('auth_api.success_message'),new AdminResource($auth));
        }
        catch (\Exception $exception)
        {
            return $this->responseFail(Http::INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    public function getProfile(): JsonResponse
    {
        try
        {
            $auth = Auth::guard('admin-api')->user();
            $auth['token'] = request()->bearerToken();
            return $this->responseSuccess(Http::OK,__('auth_api.get_profile'),new AdminResource($auth));
        }
        catch (\Exception $exception)
        {
            return $this->responseFail(Http::INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

    public function home(): JsonResponse
    {

        $auth = Auth::guard('admin-api')->user();

        return $this->responseSuccess(message: 'تم الحصول علي بيانات الصفحه الرئيسيه بنجاح', data: new HomeResource($auth));
    }

    public function logout(): JsonResponse
    {
        try
        {
            auth('admin-api')->logout();
            return $this->responseSuccess(Http::OK,__('auth_api.logout'));
        }
        catch (\Exception $exception)
        {
            return $this->responseFail(Http::INTERNAL_SERVER_ERROR, $exception->getMessage());
        }
    }

}
