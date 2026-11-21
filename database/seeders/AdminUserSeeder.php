<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Create the default admin login if it does not exist yet.
     * An existing "admin" user is never modified, so this is safe on live data.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'email' => 'admin@thinkbright.test',
                'password' => Hash::make('admin123456'),
                'role' => 'admin',
                'is_active' => 1,
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $admin->forceFill(['email_verified_at' => now()])->save();
        }
    }
}
