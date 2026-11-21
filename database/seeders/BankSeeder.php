<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /** Malaysian banks; safe to re-run (matches by name). */
    public function run(): void
    {
        $banks = [
            'Maybank', 'CIMB Bank', 'Public Bank', 'RHB Bank', 'Hong Leong Bank',
            'AmBank', 'Bank Islam', 'BSN', 'Alliance Bank', 'Affin Bank',
            'OCBC Bank', 'UOB Bank', 'HSBC Bank', 'Standard Chartered',
            'Bank Rakyat', 'Agrobank',
        ];

        foreach ($banks as $name) {
            Bank::withTrashed()->firstOrCreate(['name' => $name]);
        }
    }
}
