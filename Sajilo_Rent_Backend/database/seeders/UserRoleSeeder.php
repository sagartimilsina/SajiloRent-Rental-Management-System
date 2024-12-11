<?php

namespace Database\Seeders;

use App\Models\UserRoleManagement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role_name' => 'Super Admin'],
            ['role_name' => 'Admin'],
            ['role_name' => 'User']
        ];

        // Loop through each role and create it in the database
        foreach ($roles as $role) {
            UserRoleManagement::create($role);
        }
    }
}
