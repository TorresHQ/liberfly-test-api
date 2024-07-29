<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Melissa Giuberti L. Schaffer',
            'email' => 'melissa@liberfly.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::create([
            'name' => 'Héctor Queiroz Torres',
            'email' => 'hector@liberfly.com',
            'password' => bcrypt('password'),
        ]);
    }
}
