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
        User::firstOrCreate(
            ['email' => 'superadmin@monasso.com'],
            [
                'name' => 'SaaS Platform Owner',
                'phone' => '0600000000',
                'password' => Hash::make('superadminpassword'),
                'association_id' => null,
                'is_active' => true,
                'email_verified_at' => now()
            ]
        )->assignRole('superadmin');

        $associations = [
            [
                'id' => 1,
                'name' => 'Association Marocaine des Droits de l\'Homme (AMDH)',
                'email' => 'contact@amdh.ma',
                'address' => 'Rue Oum Errabia, Rabat',
                'announcement_status' => 'active',
                'creation_date' => now(),
                'is_validated' => true,
            ],
            [
                'id' => 2,
                'name' => 'Fédération Royale Marocaine de Football (FRMF)',
                'email' => 'info@frmf.ma',
                'address' => 'Complexe Mohammed VI, Maârif, Casablanca',
                'announcement_status' => 'active',
                'creation_date' => now(),
                'is_validated' => true,
            ],
            [
                'id' => 3,
                'name' => 'Association des Enseignants des Sciences de la Vie et de la Terre (AESVT)',
                'email' => 'contact@aesvt.ma',
                'address' => 'Angle Rue 2 et Rue 5, Hay Riad, Rabat',
                'announcement_status' => 'active',
                'creation_date' => now(),
                'is_validated' => true,
            ]
        ];

        foreach ($associations as $association) {
            Association::firstOrCreate(
                ['id' => $association['id']],
                $association
            );
        }

        // Create users for each association with real Moroccan names
        $this->createAMDHUsers();       // Human Rights Association
        $this->createFRMFUsers();       // Football Federation
        $this->createAESVTUsers();      // Education Association
    }

    protected function createAMDHUsers()
    {
        $associationId = 1;

        // Admin
        User::firstOrCreate(
            ['email' => 'khalid.amdh@monasso.com'],
            [
                'name' => 'Khalid El Amrani',
                'phone' => '0612345678',
                'password' => Hash::make('password'),
                'association_id' => $associationId,
                'is_active' => true,
                'email_verified_at' => now()
            ]
        )->assignRole('admin');

        // Board Member
        User::firstOrCreate(
            ['email' => 'amina.amdh@monasso.com'],
            [
                'name' => 'Amina Belhaj',
                'phone' => '0623456789',
                'password' => Hash::make('password'),
                'association_id' => $associationId,
                'is_active' => true,
                'email_verified_at' => now()
            ]
        )->assignRole('board');

        // Supervisor
        User::firstOrCreate(
            ['email' => 'mohamed.amdh@monasso.com'],
            [
                'name' => 'Mohamed Zouhair',
                'phone' => '0634567890',
                'password' => Hash::make('password'),
                'association_id' => $associationId,
                'is_active' => true,
                'email_verified_at' => now()
            ]
        )->assignRole('supervisor');

        // Members
        $members = [
            ['name' => 'Fatima Zahra Alaoui', 'phone' => '0645678901'],
            ['name' => 'Youssef Benali', 'phone' => '0656789012'],
            ['name' => 'Leila Cherkaoui', 'phone' => '0667890123'],
        ];

        foreach ($members as $i => $member) {
            User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $member['name'])) . '.amdh@monasso.com'],
                [
                    'name' => $member['name'],
                    'phone' => $member['phone'],
                    'password' => Hash::make('password'),
                    'association_id' => $associationId,
                    'is_active' => ($i % 2 == 0),
                    'email_verified_at' => now()
                ]
            )->assignRole('member');
        }
    }

    protected function createFRMFUsers()
    {
        $associationId = 2;

        // Admin
        User::firstOrCreate(
            ['email' => 'fouzi.frmf@monasso.com'],
            [
                'name' => 'Fouzi Lekjaa',
                'phone' => '0678901234',
                'password' => Hash::make('password'),
                'association_id' => $associationId,
                'is_active' => true,
                'email_verified_at' => now()
            ]
        )->assignRole('admin');

        // Board Member
        User::firstOrCreate(
            ['email' => 'hicham.frmf@monasso.com'],
            [
                'name' => 'Hicham El Amrani',
                'phone' => '0689012345',
                'password' => Hash::make('password'),
                'association_id' => $associationId,
                'is_active' => true,
                'email_verified_at' => now()
            ]
        )->assignRole('board');

        // Supervisor
        User::firstOrCreate(
            ['email' => 'nadia.frmf@monasso.com'],
            [
                'name' => 'Nadia Fassi',
                'phone' => '0690123456',
                'password' => Hash::make('password'),
                'association_id' => $associationId,
                'is_active' => true,
                'email_verified_at' => now()
            ]
        )->assignRole('supervisor');

        // Members (football players/staff)
        $members = [
            ['name' => 'Yassine Bounou', 'phone' => '0611223344'],
            ['name' => 'Achraf Hakimi', 'phone' => '0622334455'],
            ['name' => 'Noussair Mazraoui', 'phone' => '0633445566'],
        ];

        foreach ($members as $i => $member) {
            User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $member['name'])) . '.frmf@monasso.com'],
                [
                    'name' => $member['name'],
                    'phone' => $member['phone'],
                    'password' => Hash::make('password'),
                    'association_id' => $associationId,
                    'is_active' => true,
                    'email_verified_at' => now()
                ]
            )->assignRole('member');
        }
    }

    protected function createAESVTUsers()
    {
        $associationId = 3;

        // Admin
        User::firstOrCreate(
            ['email' => 'hassan.aesvt@monasso.com'],
            [
                'name' => 'Hassan El Mansouri',
                'phone' => '0644556677',
                'password' => Hash::make('password'),
                'association_id' => $associationId,
                'is_active' => true,
                'email_verified_at' => now()
            ]
        )->assignRole('admin');

        // Board Member
        User::firstOrCreate(
            ['email' => 'fatima.aesvt@monasso.com'],
            [
                'name' => 'Fatima Ezzahra El Moudden',
                'phone' => '0655667788',
                'password' => Hash::make('password'),
                'association_id' => $associationId,
                'is_active' => true,
                'email_verified_at' => now()
            ]
        )->assignRole('board');

        // Supervisor
        User::firstOrCreate(
            ['email' => 'karim.aesvt@monasso.com'],
            [
                'name' => 'Karim Bennani',
                'phone' => '0666778899',
                'password' => Hash::make('password'),
                'association_id' => $associationId,
                'is_active' => true,
                'email_verified_at' => now()
            ]
        )->assignRole('supervisor');

        // Members (teachers)
        $members = [
            ['name' => 'Samira El Fassi', 'phone' => '0677889900'],
            ['name' => 'Ahmed Touimi', 'phone' => '0688990011'],
            ['name' => 'Zineb El Ouafi', 'phone' => '0699001122'],
        ];

        foreach ($members as $i => $member) {
            User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $member['name'])) . '.aesvt@monasso.com'],
                [
                    'name' => $member['name'],
                    'phone' => $member['phone'],
                    'password' => Hash::make('password'),
                    'association_id' => $associationId,
                    'is_active' => ($i % 2 == 1),
                    'email_verified_at' => now()
                ]
            )->assignRole('member');
        }
    }
}