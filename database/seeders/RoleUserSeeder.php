<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin users
        $adminRole = \App\Models\Role::where('name', 'admin')->first();

        $adminUser = \App\Models\User::where('email', 'melissa@liberfly.com')->first();
        
        $adminUser->roles()->attach($adminRole);

        // User users
        $userRole = \App\Models\Role::where('name', 'user')->first();

        $userUser = \App\Models\User::where('email', 'hector@liberfly.com')->first();

        $userUser->roles()->attach($userRole);
    }
}
