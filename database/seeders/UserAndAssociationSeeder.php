<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Association;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAndAssociationSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $association = Association::create([
                'name' => "Association $i",
                'address' => "Address $i",
                'email' => "association$i@example.com",
                'announcement_status' => fake()->sentence,
                'creation_date' => now()->subYears(rand(1,5)),
                'is_validated' => true,
                'validation_date' => now()->subMonths(rand(1,12)),
            ]);

            $superAdmin = User::create([
                'name' => "SuperAdmin $i",
                'email' => "superadmin$i@example.com",
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber,
                'association_id' => $association->id,
                'address' => fake()->address,
                'bio' => fake()->paragraph,
                'is_active' => true,
            ]);
            $superAdmin->assignRole('superadmin');

            $admin = User::create([
                'name' => "Admin $i",
                'email' => "admin$i@example.com",
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber,
                'association_id' => $association->id,
                'address' => fake()->address,
                'bio' => fake()->paragraph,
                'is_active' => true,
            ]);
            $admin->assignRole('admin');

            $board = User::create([
                'name' => "Board $i",
                'email' => "board$i@example.com",
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber,
                'association_id' => $association->id,
                'address' => fake()->address,
                'bio' => fake()->paragraph,
                'is_active' => true,
            ]);
            $board->assignRole('board');

            $supervisor = User::create([
                'name' => "Supervisor $i",
                'email' => "supervisor$i@example.com",
                'password' => Hash::make('password'),
                'phone' => fake()->phoneNumber,
                'association_id' => $association->id,
                'address' => fake()->address,
                'bio' => fake()->paragraph,
                'is_active' => true,
            ]);
            $supervisor->assignRole('supervisor');

            for ($m = 1; $m <= 10; $m++) {
                $member = User::create([
                    'name' => "Member {$i}_{$m}",
                    'email' => "member{$i}_{$m}@example.com",
                    'password' => Hash::make('password'),
                    'phone' => fake()->phoneNumber,
                    'association_id' => $association->id,
                    'address' => fake()->address,
                    'bio' => fake()->paragraph,
                    'is_active' => true,
                ]);
                $member->assignRole('member');
            }
        }
    }
}
