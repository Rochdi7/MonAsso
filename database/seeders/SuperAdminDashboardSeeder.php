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
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminDashboardSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 5) as $i) {
            $association = Association::firstOrCreate(
                ['email' => "association$i@monasso.com"],
                [
                    'name' => "Association $i",
                    'address' => $faker->address,
                    'announcement_status' => $faker->sentence,
                    'creation_date' => now()->subYears(rand(1, 5)),
                    'is_validated' => true,
                    'validation_date' => now()->subDays(rand(1, 30)),
                ]
            );

            $members = [];
            foreach (range(1, 10) as $j) {
                $user = User::firstOrCreate(
                    ['email' => "member{$i}_{$j}@monasso.com"],
                    [
                        'name' => "Member {$i}-{$j}",
                        'password' => Hash::make('password'),
                        'phone' => $faker->phoneNumber,
                        'is_active' => true,
                        'association_id' => $association->id,
                        'address' => $faker->address,
                        'bio' => $faker->paragraph,
                    ]
                );
                $user->assignRole('member');
                $members[] = $user;
            }

            foreach ($members as $member) {
                Cotisation::firstOrCreate(
                    [
                        'user_id' => $member->id,
                        'association_id' => $association->id,
                        'year' => now()->year,
                    ],
                    [
                        'approved_by' => null,
                        'amount' => rand(500, 2000),
                        'status' => rand(0, 3),
                        'paid_at' => now()->subDays(rand(1, 365)),
                        'receipt_number' => Str::uuid(),
                    ]
                );
            }

            foreach (range(1, 5) as $c) {
                Contribution::firstOrCreate(
                    [
                        'description' => "Contribution {$c} for Assoc {$association->id}",
                        'association_id' => $association->id,
                    ],
                    [
                        'type' => rand(1, 2),
                        'amount' => $faker->randomFloat(2, 100, 5000),
                        'received_at' => now()->subDays(rand(1, 365)),
                    ]
                );
            }

            foreach (range(1, 3) as $e) {
                Expense::firstOrCreate(
                    [
                        'title' => "Expense $e for Assoc {$association->id}",
                        'association_id' => $association->id,
                    ],
                    [
                        'description' => $faker->sentence,
                        'amount' => $faker->randomFloat(2, 50, 1500),
                        'spent_at' => now()->subDays(rand(1, 365)),
                    ]
                );
            }

            foreach (range(1, 2) as $m) {
                Meeting::firstOrCreate(
                    [
                        'title' => "Meeting $m for Assoc {$association->id}",
                        'association_id' => $association->id,
                    ],
                    [
                        'description' => $faker->paragraph,
                        'datetime' => now()->addDays(rand(1, 30)),
                        'status' => rand(0, 1),
                        'location' => $faker->city,
                        'organizer_id' => $faker->randomElement($members)->id,
                    ]
                );
            }

            foreach (range(1, 2) as $ev) {
                Event::firstOrCreate(
                    [
                        'title' => "Event $ev for Assoc {$association->id}",
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
        }

        $this->command->info('✅ SuperAdmin Dashboard Seeder completed.');
    }
}
