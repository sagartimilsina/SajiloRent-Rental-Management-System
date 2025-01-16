<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\UserRoleManagement;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_id = UserRoleManagement::where('role_name', 'Super Admin')->first()->id;
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234567890'),
            'role_id' => $role_id,
            'email_verified_at' => now(),
            'is_seeded' => 1,
            'otp_is_verified' => 1,
            'otp_code_verified_at' => now(),
            'status' => 1,
            
        ]);
    }
}
