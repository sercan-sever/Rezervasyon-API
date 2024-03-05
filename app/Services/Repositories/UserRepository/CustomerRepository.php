<?php

namespace App\Services\Repositories\UserRepository;

use App\Enums\RoleType;
use App\Models\User;
use App\Services\Interfaces\UserInterface\CustomerInterface;
use Illuminate\Support\Facades\Hash;

class CustomerRepository implements CustomerInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return User
     */
    public function create(string $name, string $email, string $password): User
    {
        $customer = User::query()->create([
            'name'     => $name,
            'email'    => $email,
            'password' => Hash::make(passwordGeneration(password: $password)),
        ]);
        $customer->assignRole(RoleType::CUSTOMER);

        return $customer;
    }


    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getByEmail(string $email): ?User
    {
        $customer = User::query()->select(['id', 'name', 'created_at'])->whereEmail($email)->first();

        return !empty($customer) && $customer->hasRole(RoleType::CUSTOMER->value) ? $customer : null;
    }


    /**
     * @param string $id
     *
     * @return User|null
     */
    public function getById(int $id): ?User
    {
        $customer = User::query()->select(['id', 'name', 'created_at'])->find($id);

        return !empty($customer) && $customer->hasRole(RoleType::CUSTOMER->value) ? $customer : null;
    }
}
