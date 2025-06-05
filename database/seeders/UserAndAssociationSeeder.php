<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Association;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAndAssociationSeeder extends Seeder
{
    public function run(): void
    {
        // Create associations without setting 'id'
        $asso1 = Association::create([
            'name' => 'Asso Super',
            'email' => 'super@asso.com',
            'address' => '123 Rue Super',
            'announcement_status' => 'active',
            'creation_date' => now(),
        ]);

        $asso2 = Association::create([
            'name' => 'Asso Admin',
            'email' => 'admin@asso.com',
            'address' => '456 Rue Admin',
            'announcement_status' => 'active',
            'creation_date' => now(),
        ]);

        $asso3 = Association::create([
            'name' => 'Asso Membre',
            'email' => 'membre@asso.com',
            'address' => '789 Rue Membre',
            'announcement_status' => 'active',
            'creation_date' => now(),
        ]);

        // Create users
        $super = User::create([
            'name' => 'Super Admin',
            'email' => 'super@asso.com',
            'phone' => '0600000001',
            'password' => Hash::make('password'),
            'association_id' => $asso1->id,
        ]);
        $super->assignRole('super_admin');

        $admin = User::create([
            'name' => 'Association Admin',
            'email' => 'admin@asso.com',
            'phone' => '0600000002',
            'password' => Hash::make('password'),
            'association_id' => $asso2->id,
        ]);
        $admin->assignRole('admin');

        $membre = User::create([
            'name' => 'Regular Member',
            'email' => 'membre@asso.com',
            'phone' => '0600000003',
            'password' => Hash::make('password'),
            'association_id' => $asso3->id,
        ]);
        $membre->assignRole('membre');
    }
}
