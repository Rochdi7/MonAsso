<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class MemberStatisticsSeeder extends Seeder
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

        // Clean up old member statistics entries
        $keys = [
            'member_cotisation_status',
            'member_profile_completeness',
            'member_cotisation_history_chart',
        ];

        DB::table('statistics')->whereIn('key', $keys)->delete();

        // Cotisation Status Donut
        DB::table('statistics')->insert([
            'key' => 'member_cotisation_status',
            'value' => json_encode([
                'Paid' => rand(100, 500),
                'Unpaid' => rand(10, 100),
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Profile completeness
        DB::table('statistics')->insert([
            'key' => 'member_profile_completeness',
            'value' => json_encode([
                'completion' => rand(50, 100),
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Cotisation History Chart Data
        DB::table('statistics')->insert([
            'key' => 'member_cotisation_history_chart',
            'value' => json_encode([
                '6' => [
                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'series' => [
                        ['name' => 'Paid', 'data' => array_map(fn() => rand(10, 80), range(1, 6))],
                    ],
                ],
                '12' => [
                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    'series' => [
                        ['name' => 'Paid', 'data' => array_map(fn() => rand(10, 100), range(1, 12))],
                    ],
                ],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✅ Member statistics seeded successfully!');
    }
}
