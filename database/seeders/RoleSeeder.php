<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Bouncer;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Bouncer::role()->firstOrCreate([ 'name' => 'superadmin', 'title' => 'Super Admin', ]);
    	Bouncer::role()->firstOrCreate([ 'name' => 'admin', 'title' => 'Admin', ]);
    	Bouncer::role()->firstOrCreate([ 'name' => 'supervisor', 'title' => 'Supervisor', ]);
    	Bouncer::role()->firstOrCreate([ 'name' => 'leader', 'title' => 'Leader', ]);
    	Bouncer::role()->firstOrCreate([ 'name' => 'operator', 'title' => 'Operator', ]);
    	Bouncer::role()->firstOrCreate([ 'name' => 'driver', 'title' => 'Driver', ]);
    	Bouncer::role()->firstOrCreate([ 'name' => 'cleaner', 'title' => 'Cleaner', ]);
    }
}
