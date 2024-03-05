<?php

namespace App\Services\Repositories\AuthenticateRepository;

use App\Enums\RoleType;
use App\Http\Resources\Customer\CustomerResource;
use App\Models\User;
use App\Notifications\Customer\RegisteredCustomerNotification;
use App\Services\Interfaces\AuthInterface\AuthCustomerInterface;
use App\Services\Repositories\UserRepository\CustomerRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthCustomerRepository implements AuthCustomerInterface
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

            if (!auth()->user()->hasRole(RoleType::CUSTOMER->value))
                return response()->json(['success' => false, 'message' => 'Bilgileriniz Kayıtlarımız İle Uyuşmuyor !!!'], Response::HTTP_UNAUTHORIZED);


            $token = auth()->user()->createToken('CustomerAuth')->accessToken;

            return response()->json([
                'success' => true,
                'message' => 'Giriş Yapıldı.',
                'data' => [
                    'customer' => new CustomerResource(resource: auth()->user()),
                    'token' => $token,
                ]
            ], Response::HTTP_OK);
        }

        return response()->json(['success' => false, 'message' => 'Bilgileriniz Kayıtlarımız İle Uyuşmuyor !!!'], Response::HTTP_UNAUTHORIZED);
    }


    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return JsonResponse
     */
    public function register(string $name, string $email, string $password): JsonResponse
    {
        $customer = (new CustomerRepository())->create(name: $name, email: $email, password: $password);

        $token = $customer->createToken('CustomerAuth')->accessToken;

        $customer->notify(new RegisteredCustomerNotification(user: $customer));

        return response()->json([
            'success' => true,
            'message' => 'Kayıt Yapıldı.',
            'data' => [
                'customer' => new CustomerResource(resource: $customer),
                'token' => $token,
            ],
        ], Response::HTTP_OK);
    }


    /**
     * @param string $email
     *
     * @return JsonResponse
     */
    public function forgotPassword(string $email): JsonResponse
    {
        $customer = (new CustomerRepository())->getByEmail(email: $email);

        if (empty($customer))
            return response()->json([
                'success' => false,
                'message' => 'Bilgileriniz Kayıtlarımız İle Uyuşmuyor !!!'
            ], Response::HTTP_UNAUTHORIZED);


        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT)
            return response()->json(['success' => true, 'message' => "Mailinizi Kontrol Ediniz."], Response::HTTP_OK);


        return response()->json(['success' => false, 'message' => "Bir Sorun Oluştu Lütfen Tekrar Deneyiniz !!!"], Response::HTTP_UNAUTHORIZED);
    }


    /**
     * @param string $email
     * @param string $password
     * @param string $passwordConfirmation
     * @param string $token
     *
     * @return JsonResponse
     */
    public function resetPassword(string $email, string $password, string $passwordConfirmation, string $token): JsonResponse
    {
        $customer = (new CustomerRepository())->getByEmail(email: $email);

        if (empty($customer))
            return response()->json([
                'success' => false,
                'message' => 'Bilgileriniz Kayıtlarımız İle Uyuşmuyor !!!'
            ], Response::HTTP_UNAUTHORIZED);


        if (!Password::tokenExists(user: $customer, token: $token))
            return response()->json([
                'success' => false,
                'message' => 'Token Süresi Doldu. Tekrardan Sıfırlama Maili Gönderip Deneyebilirsiniz.'
            ], Response::HTTP_UNAUTHORIZED);


        $status = Password::reset(
            [
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $passwordConfirmation,
                'token' => $token
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make(passwordGeneration(password: $password))
                ]);

                $user->save();
            }
        );


        if ($status === Password::PASSWORD_RESET)
            return response()->json([
                'success' => true,
                'message' => "Şifreniz Başarıyla Güncellenmiştir. Yeni Şifreniz İle Giriş Yapabilirsiniz."
            ], Response::HTTP_OK);


        return response()->json(['success' => false, 'message' => "Bir Sorun Oluştu Lütfen Tekrar Deneyiniz "], Response::HTTP_UNAUTHORIZED);
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
