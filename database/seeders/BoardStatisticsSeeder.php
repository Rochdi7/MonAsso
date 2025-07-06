<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class BoardStatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create table if not exists
        if (!Schema::hasTable('statistics')) {
            Schema::create('statistics', function ($table) {
                $table->id();
                $table->string('key')->unique();
                $table->json('value');
                $table->timestamps();
            });
        }

        // Delete old board statistics entries
        $keys = [];
        foreach (range(1, 2) as $a) {
            $keys = array_merge($keys, [
                "board_member_growth_$a",
                "board_cotisation_status_$a",
                "board_monthly_cotisations_$a",
                "board_event_participation_$a",
            ]);
        }

        DB::table('statistics')->whereIn('key', $keys)->delete();

        foreach (range(1, 2) as $a) {

            // Member growth chart
            DB::table('statistics')->insert([
                'key' => "board_member_growth_$a",
                'value' => json_encode([
                    '6' => [
                        'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        'series' => [
                            [
                                'name' => 'New Members',
                                'data' => array_map(fn() => rand(10, 60), range(1, 6))
                            ]
                        ]
                    ],
                    '12' => [
                        'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        'series' => [
                            [
                                'name' => 'New Members',
                                'data' => array_map(fn() => rand(15, 70), range(1, 12))
                            ]
                        ]
                    ],
                    'all' => [
                        'categories' => ['2021', '2022', '2023', '2024', '2025'],
                        'series' => [
                            [
                                'name' => 'New Members',
                                'data' => [
                                    rand(150, 250),
                                    rand(180, 300),
                                    rand(200, 350),
                                    rand(250, 400),
                                    rand(300, 500)
                                ]
                            ]
                        ]
                    ],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Cotisation status (totals)
            DB::table('statistics')->insert([
                'key' => "board_cotisation_status_$a",
                'value' => json_encode([
                    'Paid' => rand(5000, 15000),
                    'Pending' => rand(500, 3000),
                    'Overdue' => rand(100, 1500),
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Monthly Cotisations
            DB::table('statistics')->insert([
                'key' => "board_monthly_cotisations_$a",
                'value' => json_encode([
                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'series' => [
                        [
                            'name' => 'Cotisations',
                            'data' => array_map(fn() => rand(1000, 4000), range(1, 6))
                        ]
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Event participation chart
            DB::table('statistics')->insert([
                'key' => "board_event_participation_$a",
                'value' => json_encode([
                    'events' => [
                        [
                            'name' => "Annual General Meeting - Assoc $a",
                            'registered' => 80 + $a * 20,
                            'attended' => 60 + $a * 15,
                        ],
                        [
                            'name' => "Summer Workshop - Assoc $a",
                            'registered' => 40 + $a * 15,
                            'attended' => 30 + $a * 10,
                        ],
                        [
                            'name' => "Q3 Townhall - Assoc $a",
                            'registered' => 20 + $a * 10,
                            'attended' => 15 + $a * 8,
                        ],
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Board statistics seeded successfully!');
    }
}
