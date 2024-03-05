<?php

namespace App\Http\Controllers\API\V1\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Admin\Auth\LoginRequest as AdminLoginRequest;
use App\Services\Interfaces\AuthInterface\AuthAdminInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAuthenticateController extends Controller
{

    /**
     * @param AuthAdminInterface $authAdmin
     *
     * @return void
     */
    public function __construct(private AuthAdminInterface $authAdmin)
    {
        //
    }


    /**
     * @param AdminLoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(AdminLoginRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->authAdmin->login(
            email: $valid['email'],
            password: $valid['password'],
        );
    }


    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return $this->authAdmin->logout();
    }
}
