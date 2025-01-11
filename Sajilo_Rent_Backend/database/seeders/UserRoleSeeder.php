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
            ['role_name' => 'Super Admin', 'created_by' => 'System'],
            ['role_name' => 'Admin', 'created_by' => 'Super Admin'],
            ['role_name' => 'User', 'created_by' => 'Super Admin'],
        ];

        // Insert roles into the database
        foreach ($roles as $role) {
            UserRoleManagement::create($role);
        }
    }

}
