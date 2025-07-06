<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\User;
use App\Models\Cotisation;
use App\Models\Meeting;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class MemberDashboardSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create or get association
        $association = Association::firstOrCreate(
            ['email' => 'member_dashboard_asso@example.com'],
            [
                'name' => 'Member Dashboard Association',
                'address' => $faker->address,
                'announcement_status' => $faker->sentence,
                'creation_date' => $faker->date(),
                'is_validated' => true,
                'validation_date' => now(),
            ]
        );

        // Create or get the member user
        $member = User::firstOrCreate(
            ['email' => 'member_dashboard_user@example.com'],
            [
                'name' => 'Member User',
                'password' => Hash::make('password'),
                'phone' => $faker->phoneNumber,
                'profile_photo' => 'build/images/user/avatar-1.jpg',
                'is_active' => true,
                'association_id' => $association->id,
                'address' => $faker->address,
                'bio' => $faker->paragraph,
            ]
        );
        $member->assignRole('member');

        // Cotisations
        $cotisations = [
            [
                'year' => 2024,
                'amount' => 1500,
                'status' => 2,
                'paid_at' => null,
                'receipt_number' => null,
            ],
            [
                'year' => 2024,
                'amount' => 250,
                'status' => 0,
                'paid_at' => null,
                'receipt_number' => null,
            ],
            [
                'year' => 2023,
                'amount' => 1250,
                'status' => 1,
                'paid_at' => now()->subMonths(12),
                'receipt_number' => Str::uuid(),
            ],
        ];

        foreach ($cotisations as $data) {
            Cotisation::firstOrCreate(
                [
                    'user_id' => $member->id,
                    'association_id' => $association->id,
                    'year' => $data['year'],
                ],
                $data
            );
        }

        // Meeting
        Meeting::firstOrCreate(
            [
                'title' => 'Quarterly Review',
                'association_id' => $association->id,
            ],
            [
                'description' => $faker->paragraph,
                'datetime' => now()->addDays(10),
                'status' => 0,
                'location' => 'Main Hall',
                'organizer_id' => $member->id,
            ]
        );

        // Events
        foreach ([
            [
                'title' => 'Annual Charity Gala',
                'location' => 'Grand Ballroom',
                'start_datetime' => now()->addDays(20),
                'end_datetime' => now()->addDays(20)->addHours(3),
            ],
            [
                'title' => 'Community Workshop',
                'location' => 'Workshop Center',
                'start_datetime' => now()->addDays(35),
                'end_datetime' => now()->addDays(35)->addHours(2),
            ],
        ] as $eventData) {
            Event::firstOrCreate(
                [
                    'title' => $eventData['title'],
                    'association_id' => $association->id,
                ],
                [
                    'description' => $faker->paragraph,
                    'location' => $eventData['location'],
                    'start_datetime' => $eventData['start_datetime'],
                    'end_datetime' => $eventData['end_datetime'],
                    'status' => 1,
                ]
            );
        }

        // Documents table
        if (!Schema::hasTable('member_documents')) {
            Schema::create('member_documents', function ($table) {
                $table->id();
                $table->string('title');
                $table->string('path');
                $table->timestamps();
            });
        }

        foreach ([
            ['title' => 'Meeting Minutes - Q1 2024', 'path' => 'storage/documents/minutes-q1-2024.pdf'],
            ['title' => 'Association Bylaws', 'path' => 'storage/documents/association-bylaws.pdf'],
        ] as $doc) {
            DB::table('member_documents')->updateOrInsert(
                ['title' => $doc['title']],
                ['path' => $doc['path'], 'updated_at' => now(), 'created_at' => now()]
            );
        }

        // Profile completeness table
        if (!Schema::hasTable('member_profile_status')) {
            Schema::create('member_profile_status', function ($table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->integer('completion_percentage');
                $table->timestamps();
            });
        }

        DB::table('member_profile_status')->updateOrInsert(
            ['user_id' => $member->id],
            ['completion_percentage' => 85, 'updated_at' => now(), 'created_at' => now()]
        );

        // Cotisation chart data
        if (!Schema::hasTable('member_cotisation_history_chart')) {
            Schema::create('member_cotisation_history_chart', function ($table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('month');
                $table->integer('amount');
                $table->timestamps();
            });
        }

        foreach ([
            ['month' => 'Jan', 'amount' => 40],
            ['month' => 'Feb', 'amount' => 30],
            ['month' => 'Mar', 'amount' => 45],
            ['month' => 'Apr', 'amount' => 35],
            ['month' => 'May', 'amount' => 60],
            ['month' => 'Jun', 'amount' => 50],
        ] as $row) {
            DB::table('member_cotisation_history_chart')->updateOrInsert(
                [
                    'user_id' => $member->id,
                    'month' => $row['month'],
                ],
                [
                    'amount' => $row['amount'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $this->command->info('✅ Member Dashboard Data Seeded Successfully!');
    }
}
