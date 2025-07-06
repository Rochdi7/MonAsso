<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class SupervisorStatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create statistics table if it doesn't exist
        if (!Schema::hasTable('statistics')) {
            Schema::create('statistics', function ($table) {
                $table->id();
                $table->string('key')->unique();
                $table->json('value');
                $table->timestamps();
            });
        }

        // Safely delete previous supervisor stats
        DB::table('statistics')->whereIn('key', [
            'supervisor_member_growth',
            'supervisor_meeting_status',
            'supervisor_event_counts',
            'supervisor_document_uploads',
        ])->delete();

        // Reset auto-increment if desired
        DB::statement('ALTER TABLE statistics AUTO_INCREMENT = 1');

        // Member growth
        DB::table('statistics')->insert([
            'key' => 'supervisor_member_growth',
            'value' => json_encode([
                '3' => [
                    'categories' => ['Apr', 'May', 'Jun'],
                    'series' => [
                        [
                            'name' => 'New Members',
                            'data' => array_map(fn() => rand(15, 60), range(1, 3))
                        ]
                    ]
                ],
                '6' => [
                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'series' => [
                        [
                            'name' => 'New Members',
                            'data' => array_map(fn() => rand(20, 70), range(1, 6))
                        ]
                    ]
                ],
                '12' => [
                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    'series' => [
                        [
                            'name' => 'New Members',
                            'data' => array_map(fn() => rand(15, 80), range(1, 12))
                        ]
                    ]
                ],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Meetings created vs completed
        DB::table('statistics')->insert([
            'key' => 'supervisor_meeting_status',
            'value' => json_encode([
                'created' => 82,
                'completed' => 71,
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Events coordinated by type
        DB::table('statistics')->insert([
            'key' => 'supervisor_event_counts',
            'value' => json_encode([
                'workshops' => rand(10, 20),
                'seminars' => rand(5, 15),
                'community_outreach' => rand(3, 8),
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Documents uploaded
        DB::table('statistics')->insert([
            'key' => 'supervisor_document_uploads',
            'value' => json_encode([
                'total_files' => 482,
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✅ Supervisor statistics seeded successfully!');
    }
}
