<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::factory()->create([
            'created_at' => fake()->date('Y-m-d H:i:s')
        ]);
        $user1->assignRole(RoleType::CUSTOMER);

        $user2 = User::factory()->create([
            'created_at' => fake()->date('Y-m-d H:i:s')
        ]);
        $user2->assignRole(RoleType::CUSTOMER);

        $user3 = User::factory()->create([
            'created_at' => fake()->date('Y-m-d H:i:s')
        ]);
        $user3->assignRole(RoleType::CUSTOMER);
    }
}
