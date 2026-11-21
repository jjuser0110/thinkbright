<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Create (or reset) the default admin login.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'email' => 'admin@thinkbright.test',
                'password' => Hash::make('admin123456'),
                'role' => 'admin',
                'is_active' => 1,
                'bank_id' => null,
            ]
        );

        $admin->forceFill(['email_verified_at' => $admin->email_verified_at ?? now()])->save();
    }
}
