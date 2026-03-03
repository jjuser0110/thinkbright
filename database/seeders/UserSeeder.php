<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Superadmin
        $user = User::where('username', 'superadmin')->first();

        if (!$user) {
            User::create([
                'name'      => 'Superadmin',
                'username'  => 'superadmin',
                'email'     => 'superadmin@gmail.com',
                'password'  => Hash::make('admin99999'),
                'role'      => 'admin',
                'is_active' => 1,
            ]);
        }

        // System Admin
        $user = User::where('username', 'admin')->first();

        if (!$user) {
            User::create([
                'name'      => 'Admin',
                'username'  => 'admin',
                'email'     => 'admin@gmail.com',
                'password'  => Hash::make('admin99999'),
                'role'      => 'admin',
                'is_active' => 1,
            ]);
        }
    }
}