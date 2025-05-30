<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // database/seeders/SuperAdminSeeder.php
        DB::table('membres')->insert([
            'id' => Str::uuid(),
            'nom' => 'Super Admin',
            'mot_de_passe' => Hash::make('password'),
            'role' => 'super_admin',
            'is_admin' => true,
            'est_actif' => true,
        ]);

    }
}
