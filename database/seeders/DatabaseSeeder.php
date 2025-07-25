<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'staf']);
        Role::create(['name' => 'auditor']);
        Role::create(['name' => 'direktur']);
        Role::create(['name' => 'kaprodi']);
        $this->call(UserSeeder::class);
    }
}
