<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //User entity permissions
            ['name' => 'user.create', 'subject' => 'user', 'action' => 'create'],
            ['name' => 'user.read', 'subject' => 'user', 'action' => 'read'],
            ['name' => 'user.update', 'subject' => 'user', 'action' => 'update'],
            ['name' => 'user.delete', 'subject' => 'user', 'action' => 'delete'],
        ];

        foreach ($permissions as $permission) {
            \App\Models\Permission::create($permission);
        }
    }
}
