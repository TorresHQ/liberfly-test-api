<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //User permissions
        $userRole = Role::where('name', 'admin')->first();

        $permissions = Permission::all();

        $adminRole->permissions()->attach($permissions);
    }
}
