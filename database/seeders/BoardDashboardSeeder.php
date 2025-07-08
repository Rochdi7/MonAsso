<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\User;
use App\Models\Cotisation;
use App\Models\Event;
use App\Models\Meeting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class BoardDashboardSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Ensure the table for event participation exists
        if (!Schema::hasTable('board_event_participation')) {
            Schema::create('board_event_participation', function ($table) {
                $table->id();
                $table->string('event_title');
                $table->integer('registered');
                $table->integer('attended');
                $table->timestamps();
            });
        }

        foreach (range(1, 2) as $a) {

            // Check or create Association
            $association = Association::firstOrCreate(
                ['email' => "board_assoc$a@monasso.com"],
                [
                    'name' => "Board Assoc $a",
                    'address' => $faker->address,
                    'announcement_status' => $faker->sentence,
                    'creation_date' => now()->subMonths(rand(1, 12)),
                    'is_validated' => true,
                    'validation_date' => now()->subDays(rand(1, 30)),
                ]
            );

            // Create or retrieve the board user
            $boardUser = User::firstOrCreate(
                ['email' => "board_user$a@monasso.com"],
                [
                    'name' => "Board User $a",
                    'password' => Hash::make('password'),
                    'phone' => $faker->phoneNumber,
                    'is_active' => true,
                    'association_id' => $association->id,
                    'address' => $faker->address,
                    'bio' => $faker->paragraph,
                ]
            );
            $boardUser->assignRole('board');

            $members = [];
            foreach (range(1, 20) as $i) {
                $member = User::firstOrCreate(
                    ['email' => "assoc{$a}_member{$i}@monasso.com"],
                    [
                        'name' => "Assoc{$a}_Member{$i}",
                        'password' => Hash::make('password'),
                        'phone' => $faker->phoneNumber,
                        'is_active' => rand(0, 1),
                        'association_id' => $association->id,
                        'address' => $faker->address,
                        'bio' => $faker->paragraph,
                    ]
                );
                $member->assignRole('member');
                $members[] = $member;
            }

            foreach (range(1, 10) as $i) {
                $randomMember = $faker->randomElement($members);

                Cotisation::firstOrCreate(
                    [
                        'user_id' => $randomMember->id,
                        'association_id' => $association->id,
                        'year' => now()->year,
                    ],
                    [
                        'approved_by' => $boardUser->id,
                        'amount' => rand(100, 500),
                        'status' => rand(0, 3),
                        'paid_at' => rand(0, 1) ? now()->subDays(rand(1, 180)) : null,
                        'receipt_number' => Str::uuid(),
                    ]
                );
            }

            foreach (range(1, 2) as $m) {
                Meeting::firstOrCreate(
                    [
                        'title' => "Meeting $m for Assoc $a",
                        'association_id' => $association->id,
                    ],
                    [
                        'description' => $faker->paragraph,
                        'datetime' => now()->addDays(rand(5, 30)),
                        'status' => 0,
                        'location' => $faker->city,
                        'organizer_id' => $boardUser->id,
                    ]
                );
            }

            foreach ([
                'Annual General Meeting',
                'Summer Workshop',
                'Q3 Townhall'
            ] as $title) {
                Event::firstOrCreate(
                    [
                        'title' => "$title - Assoc $a",
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

            // Event participation entries
            foreach ([
                "Annual General Meeting - Assoc $a" => [100 + $a * 20, 80 + $a * 15],
                "Summer Workshop - Assoc $a" => [50 + $a * 15, 40 + $a * 10],
                "Q3 Townhall - Assoc $a" => [30 + $a * 10, 25 + $a * 8],
            ] as $eventTitle => [$registered, $attended]) {
                DB::table('board_event_participation')->updateOrInsert(
                    ['event_title' => $eventTitle],
                    [
                        'registered' => $registered,
                        'attended' => $attended,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }

        $this->command->info('✅ Board Dashboard Seeder finished!');
    }
}
