<?php

namespace App\Http\Controllers\API\V1\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Customer\Auth\ForgotPasswordRequest;
use App\Http\Requests\API\V1\Customer\Auth\LoginRequest;
use App\Http\Requests\API\V1\Customer\Auth\RegisterRequest;
use App\Http\Requests\API\V1\Customer\Auth\ResetPasswordRequest;
use App\Services\Interfaces\AuthInterface\AuthCustomerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerAuthenticateController extends Controller
{
    /**
     * @return AuthCustomerInterface $authCustomer
     */
    public function __construct(private AuthCustomerInterface $authCustomer)
    {
        //
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->authCustomer->login(
            email: $valid['email'],
            password: $valid['password']
        );
    }


    /**
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->authCustomer->register(
            name: $valid['name'],
            email: $valid['email'],
            password: $valid['password']
        );
    }


    /**
     * @param ForgotPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->authCustomer->forgotPassword(email: $valid['email']);
    }


    /**
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $valid = $request->validated();

        return $this->authCustomer->resetPassword(
            email: $valid['email'],
            password: $valid['password'],
            passwordConfirmation: $valid['password_confirmation'],
            token: $valid['token']
        );
    }


    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return $this->authCustomer->logout();
    }
}
