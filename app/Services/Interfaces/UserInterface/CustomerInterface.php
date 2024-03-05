<?php

namespace App\Services\Interfaces\UserInterface;

use App\Models\User;

interface CustomerInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return User
     */
    public function create(string $name, string $email, string $password): User;


    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getByEmail(string $email): ?User;


    /**
     * @param string $id
     *
     * @return User|null
     */
    public function getById(int $id): ?User;
}
