<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database. Every seeder here is safe to re-run on live data.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            BankSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
