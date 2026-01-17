<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@heartway.com',
            'password' => bcrypt('12345678'),
            'role' => 'superadmin',
        ]);

        User::factory()->create([
            'name' => 'School Admin',
            'email' => 'schooladmin@heartway.com',
            'password' => bcrypt('12345678'),
            'role' => 'school_admin',
        ]);

        User::factory()->create([
            'name' => 'Parent User',
            'email' => 'parent@heartway.com',
            'password' => bcrypt('12345678'),
            'role' => 'parent',
        ]);
    }
}
