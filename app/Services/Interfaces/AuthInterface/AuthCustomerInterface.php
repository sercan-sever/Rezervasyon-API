<?php

namespace App\Services\Interfaces\AuthInterface;

use App\Services\Interfaces\BaseInterfaces\AuthenticateInterface;
use Illuminate\Http\JsonResponse;

interface AuthCustomerInterface extends AuthenticateInterface
{

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return JsonResponse
     */
    public function register(string $name, string $email, string $password): JsonResponse;


    /**
     * @param string $email
     *
     * @return JsonResponse
     */
    public function forgotPassword(string $email): JsonResponse;


    /**
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     * @param string $token
     *
     * @return JsonResponse
     */
    public function resetPassword(string $email, string $password, string $passwordConfirmation, string $token): JsonResponse;
}
