<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->delete();
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);
        User::factory()->create([
            'name' => 'petugas',
            'email' => 'petugas@gmail.com',
            'role' => 'petugas',
            'password' => bcrypt('petugas123'),
        ]);
        User::factory()->create([
            'name' => 'masyarakat',
            'email' => 'masyarakat@gmail.com',
            'role' => 'masyarakat',
            'password' => bcrypt('masyarakat123'),
        ]);
    }
}
