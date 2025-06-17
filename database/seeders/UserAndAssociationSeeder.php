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
        // Create Associations
        $assoSuper = Association::create([
            'name' => 'Asso Super',
            'email' => 'super@asso.com',
            'address' => '123 Rue Super',
            'announcement_status' => 'active',
            'creation_date' => now(),
        ]);

        $assoAdmin1 = Association::create([
            'name' => 'Asso Admin One',
            'email' => 'admin1@asso.com',
            'address' => '456 Rue Admin One',
            'announcement_status' => 'active',
            'creation_date' => now(),
        ]);

        $assoAdmin2 = Association::create([
            'name' => 'Asso Admin Two',
            'email' => 'admin2@asso.com',
            'address' => '789 Rue Admin Two',
            'announcement_status' => 'active',
            'creation_date' => now(),
        ]);

        // Create Super Admin (can access everything)
        $super = User::create([
            'name' => 'Super Admin',
            'email' => 'super@asso.com',
            'phone' => '0600000001',
            'password' => Hash::make('password'),
            'association_id' => $assoSuper->id,
        ]);
        $super->assignRole('super_admin');

        // Create Admin 1
        $admin1 = User::create([
            'name' => 'Admin One',
            'email' => 'admin1@asso.com',
            'phone' => '0600000002',
            'password' => Hash::make('password'),
            'association_id' => $assoAdmin1->id,
        ]);
        $admin1->assignRole('admin');

        // Create Admin 2
        $admin2 = User::create([
            'name' => 'Admin Two',
            'email' => 'admin2@asso.com',
            'phone' => '0600000003',
            'password' => Hash::make('password'),
            'association_id' => $assoAdmin2->id,
        ]);
        $admin2->assignRole('admin');

        // Create Membres for Admin 1 Association
        for ($i = 1; $i <= 3; $i++) {
            $member = User::create([
                'name' => "Membre Admin1 $i",
                'email' => "membre_admin1_$i@asso.com",
                'phone' => "06000001" . $i,
                'password' => Hash::make('password'),
                'association_id' => $assoAdmin1->id,
            ]);
            $member->assignRole('membre');
        }

        // Create Membres for Admin 2 Association
        for ($i = 1; $i <= 3; $i++) {
            $member = User::create([
                'name' => "Membre Admin2 $i",
                'email' => "membre_admin2_$i@asso.com",
                'phone' => "06000002" . $i,
                'password' => Hash::make('password'),
                'association_id' => $assoAdmin2->id,
            ]);
            $member->assignRole('membre');
        }

        // Create Membres for Super Admin Association
        for ($i = 1; $i <= 2; $i++) {
            $member = User::create([
                'name' => "Membre Super $i",
                'email' => "membre_super$i@asso.com",
                'phone' => "06000003" . $i,
                'password' => Hash::make('password'),
                'association_id' => $assoSuper->id,
            ]);
            $member->assignRole('membre');
        }
    }
}
