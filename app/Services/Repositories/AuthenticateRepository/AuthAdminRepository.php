<?php

namespace App\Services\Repositories\AuthenticateRepository;

use App\Enums\RoleType;
use App\Http\Resources\Admin\AdminResource;
use App\Services\Interfaces\AuthInterface\AuthAdminInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthAdminRepository implements AuthAdminInterface
{
    /**
     * @param string $email
     * @param string $password
     *
     * @return JsonResponse
     */
    public function login(string $email, string $password): JsonResponse
    {
        if (Auth::attempt(['email' => $email, 'password' => passwordGeneration(password: $password)])) {

            if (auth()->user()->hasRole(RoleType::CUSTOMER->value))
                return response()->json(['success' => false, 'message' => 'Bilgileriniz Kayıtlarımız İle Uyuşmuyor !!!'], Response::HTTP_UNAUTHORIZED);


            $token = auth()->user()->createToken('AdminAuth')->accessToken;

            return response()->json([
                'success' => true,
                'message' => 'Giriş Yapıldı.',
                'data' => [
                    'admin' => new AdminResource(resource: auth()->user()),
                    'token' => $token,
                ]
            ], Response::HTTP_OK);
        }

        return response()->json(['success' => false, 'message' => 'Bilgileriniz Kayıtlarımız İle Uyuşmuyor !!!'], Response::HTTP_UNAUTHORIZED);
    }


    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json(['success' => true, 'message' => 'Çıkış Yapıldı.'], Response::HTTP_OK);
    }
}
