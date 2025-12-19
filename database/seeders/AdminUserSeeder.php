<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(
            ['role_name' => 'PemakuKepentingan'],
            ['role_id' => 4]
        );

        User::firstOrCreate(
            ['email' => 'admin@pln.local'],
            [
                'name' => 'Administrator',
                'NIP' => '99999999999999999999',
                'role_id' => $adminRole->role_id,
                'email_verified_at' => now(),
                'password' => Hash::make('admin123'),
            ]
        );
    }
}