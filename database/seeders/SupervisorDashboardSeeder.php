<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\User;
use App\Models\Meeting;
use App\Models\Event;
use App\Models\MeetingDocument;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class SupervisorDashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create association
        $association = Association::firstOrCreate(
            ['email' => 'supervisor_assoc@monasso.com'],
            [
                'name' => 'Supervisor Dashboard Association',
                'address' => $faker->address,
                'announcement_status' => $faker->sentence,
                'creation_date' => $faker->date(),
                'is_validated' => true,
                'validation_date' => now(),
            ]
        );

        // Create supervisor user
        $supervisor = User::firstOrCreate(
            ['email' => 'supervisor@monasso.com'],
            [
                'name' => 'Supervisor User',
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
        for ($i = 1; $i <= 145; $i++) {
            $user = User::firstOrCreate(
                ['email' => "supervisor_member_$i@monasso.com"],
                [
                    'name' => "New Member $i",
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

        // Meetings
        $meetings = [];
        for ($i = 1; $i <= 82; $i++) {
            $meetings[] = Meeting::firstOrCreate(
                [
                    'title' => "Meeting $i",
                    'association_id' => $association->id,
                ],
                [
                    'description' => $faker->paragraph,
                    'datetime' => now()->addDays(rand(1, 60)),
                    'status' => ($i <= 71) ? 1 : 0,
                    'location' => $faker->city,
                    'organizer_id' => $supervisor->id,
                ]
            );
        }

        // Events
        $eventsData = [
            ['title' => 'Workshop Series', 'count' => 12],
            ['title' => 'Seminars', 'count' => 8],
            ['title' => 'Community Outreach', 'count' => 5],
        ];

        foreach ($eventsData as $eventType) {
            for ($i = 1; $i <= $eventType['count']; $i++) {
                Event::firstOrCreate(
                    [
                        'title' => "{$eventType['title']} #$i",
                        'association_id' => $association->id,
                    ],
                    [
                        'description' => $faker->paragraph,
                        'location' => $faker->city,
                        'start_datetime' => now()->addDays(rand(5, 90)),
                        'end_datetime' => now()->addDays(rand(5, 90))->addHours(2),
                        'status' => 1,
                    ]
                );
            }
        }

        // Documents
        for ($i = 1; $i <= 482; $i++) {
            $randomMeeting = collect($meetings)->random();
            MeetingDocument::firstOrCreate(
                [
                    'name' => "Document $i",
                    'meeting_id' => $randomMeeting->id,
                ],
                [
                    'path' => 'storage/meeting_docs/document-' . Str::uuid() . '.pdf',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('✅ Supervisor Dashboard Data Seeded Successfully!');
    }
}
