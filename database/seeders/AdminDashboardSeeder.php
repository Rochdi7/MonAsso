<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\User;
use App\Models\Cotisation;
use App\Models\Meeting;
use App\Models\Event;
use App\Models\Contribution;
use App\Models\Expense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Role;

class AdminDashboardSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Ensure roles exist
        $roles = ['superadmin', 'admin', 'board', 'supervisor', 'member'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        foreach (range(1, 5) as $i) {
            // Check if association already exists
            $association = Association::firstOrCreate(
                ['email' => "admin_assoc$i@example.com"],
                [
                    'name' => "Admin Assoc $i",
                    'address' => $faker->address,
                    'announcement_status' => $faker->sentence,
                    'creation_date' => now()->subMonths(rand(3, 12)),
                    'is_validated' => true,
                    'validation_date' => now()->subDays(rand(1, 30)),
                ]
            );

            // SuperAdmin
            $superAdmin = User::firstOrCreate(
                ['email' => "superadmin_user$i@example.com"],
                [
                    'name' => "SuperAdmin User $i",
                    'password' => Hash::make('password'),
                    'phone' => $faker->phoneNumber,
                    'is_active' => true,
                    'association_id' => $association->id,
                    'address' => $faker->address,
                    'bio' => $faker->paragraph,
                ]
            );
            $superAdmin->assignRole('superadmin');

            // Admin
            $admin = User::firstOrCreate(
                ['email' => "admin_user$i@example.com"],
                [
                    'name' => "Admin User $i",
                    'password' => Hash::make('password'),
                    'phone' => $faker->phoneNumber,
                    'is_active' => true,
                    'association_id' => $association->id,
                    'address' => $faker->address,
                    'bio' => $faker->paragraph,
                ]
            );
            $admin->assignRole('admin');

            // Board
            $board = User::firstOrCreate(
                ['email' => "board_user$i@example.com"],
                [
                    'name' => "Board User $i",
                    'password' => Hash::make('password'),
                    'phone' => $faker->phoneNumber,
                    'is_active' => true,
                    'association_id' => $association->id,
                    'address' => $faker->address,
                    'bio' => $faker->paragraph,
                ]
            );
            $board->assignRole('board');

            // Supervisor
            $supervisor = User::firstOrCreate(
                ['email' => "supervisor_user$i@example.com"],
                [
                    'name' => "Supervisor User $i",
                    'password' => Hash::make('password'),
                    'phone' => $faker->phoneNumber,
                    'is_active' => true,
                    'association_id' => $association->id,
                    'address' => $faker->address,
                    'bio' => $faker->paragraph,
                ]
            );
            $supervisor->assignRole('supervisor');

            // Members
            $members = [];
            foreach (range(1, 10) as $j) {
                $member = User::firstOrCreate(
                    ['email' => "member{$i}_{$j}@example.com"],
                    [
                        'name' => "Member {$i}_{$j}",
                        'password' => Hash::make('password'),
                        'phone' => $faker->phoneNumber,
                        'is_active' => (bool)rand(0, 1),
                        'association_id' => $association->id,
                        'address' => $faker->address,
                        'bio' => $faker->paragraph,
                    ]
                );
                $member->assignRole('member');
                $members[] = $member;
            }

            // Cotisations for members
            foreach ($members as $member) {
                Cotisation::firstOrCreate(
                    [
                        'user_id' => $member->id,
                        'association_id' => $association->id,
                        'year' => now()->year,
                    ],
                    [
                        'approved_by' => $admin->id,
                        'amount' => 150,
                        'status' => 1,
                        'paid_at' => now()->subDays(rand(1, 60)),
                        'receipt_number' => Str::uuid(),
                    ]
                );
            }

            foreach (range(1, 2) as $m) {
                Meeting::firstOrCreate(
                    [
                        'title' => "Meeting $m for Assoc $i",
                        'association_id' => $association->id,
                    ],
                    [
                        'description' => $faker->paragraph,
                        'datetime' => now()->addDays(rand(1, 30)),
                        'status' => rand(0, 1),
                        'location' => $faker->city,
                        'organizer_id' => $admin->id,
                    ]
                );
            }

            foreach (range(1, 2) as $e) {
                Event::firstOrCreate(
                    [
                        'title' => "Event $e for Assoc $i",
                        'association_id' => $association->id,
                    ],
                    [
                        'description' => $faker->paragraph,
                        'location' => $faker->city,
                        'start_datetime' => now()->addDays(rand(5, 15)),
                        'end_datetime' => now()->addDays(rand(20, 40)),
                        'status' => 1,
                    ]
                );
            }

            Contribution::firstOrCreate(
                [
                    'description' => "Contribution for Assoc $i",
                    'association_id' => $association->id,
                ],
                [
                    'type' => rand(1, 2),
                    'amount' => 1000,
                    'received_at' => now()->subDays(rand(1, 60)),
                ]
            );

            Expense::firstOrCreate(
                [
                    'title' => "Expense for Assoc $i",
                    'association_id' => $association->id,
                ],
                [
                    'description' => $faker->sentence,
                    'amount' => 500,
                    'spent_at' => now()->subDays(rand(1, 60)),
                ]
            );
        }

        $this->command->info('✅ Admin Dashboard Seeder complete.');
    }
}
