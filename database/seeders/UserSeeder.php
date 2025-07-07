<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staf = User::create([
            'name' => 'Staf',
            'email' => 'staf@localhost',
            'password' => bcrypt('staf'),
        ]);

        $staf->assignRole('staf');

        $auditor = User::create([
            'name' => 'Auditor',
            'email' => 'auditor@localhost',
            'password' => bcrypt('auditor'),
        ]);

        $auditor->assignRole('auditor');

        $direktur = User::create([
            'name' => 'Direktur',
            'email' => 'direktur@localhost',
            'password' => bcrypt('direktur'),
        ]);

        $direktur->assignRole('direktur');

        $kaprodi = User::create([
            'name' => 'Kaprodi',
            'email' => 'kaprodi@localhost',
            'password' => bcrypt('kaprodi'),
        ]);

        $kaprodi->assignRole('kaprodi');
    }
}
