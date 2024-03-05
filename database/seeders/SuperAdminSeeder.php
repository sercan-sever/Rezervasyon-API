<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory([
            'name'     => 'Sercan Sever',
            'email'    => 'sercan.sever@gmail.com',
            'password' => Hash::make(passwordGeneration('12345678')),
        ])->create();
        $user->assignRole(RoleType::SUPER_ADMIN);
    }
}
