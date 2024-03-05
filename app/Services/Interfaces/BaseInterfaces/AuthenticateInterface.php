<?php


namespace App\Services\Interfaces\BaseInterfaces;

use Illuminate\Http\JsonResponse;

interface AuthenticateInterface
{
    /**
     * @param string $email
     * @param string $password
     *
     * @return JsonResponse
     */
    public function login(string $email, string $password): JsonResponse;

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse;
}
