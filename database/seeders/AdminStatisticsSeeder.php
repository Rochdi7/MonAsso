<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class AdminStatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create statistics table if not exists
        if (!Schema::hasTable('statistics')) {
            Schema::create('statistics', function ($table) {
                $table->id();
                $table->string('key')->unique();
                $table->json('value');
                $table->timestamps();
            });
        }

        // Clean old admin statistics
        $keys = [];
        foreach (range(1, 5) as $i) {
            $keys = array_merge($keys, [
                "admin_member_growth_$i",
                "admin_cotisation_status_$i",
                "admin_monthly_cotisations_$i",
                "admin_monthly_expenses_$i",
                "admin_contributions_by_type_$i",
            ]);
        }

        DB::table('statistics')->whereIn('key', $keys)->delete();

        foreach (range(1, 5) as $i) {
            // Member Growth Chart Data
            DB::table('statistics')->insert([
                'key' => "admin_member_growth_$i",
                'value' => json_encode([
                    '6' => [
                        'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        'series' => [
                            [
                                'name' => 'Registrations',
                                'data' => $faker->randomElements(
                                    range(10, 50), 6
                                )
                            ]
                        ]
                    ],
                    '12' => [
                        'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        'series' => [
                            [
                                'name' => 'Registrations',
                                'data' => $faker->randomElements(
                                    range(20, 80), 12
                                )
                            ]
                        ]
                    ],
                    'all' => [
                        'categories' => ['2021', '2022', '2023', '2024', '2025'],
                        'series' => [
                            [
                                'name' => 'Registrations',
                                'data' => [
                                    rand(100, 250),
                                    rand(150, 300),
                                    rand(200, 400),
                                    rand(250, 500),
                                    rand(300, 600),
                                ]
                            ]
                        ]
                    ],
                ])
            ]);

            // Cotisation Status (Donut Chart)
            DB::table('statistics')->insert([
                'key' => "admin_cotisation_status_$i",
                'value' => json_encode([
                    'Paid' => rand(100, 500),
                    'Pending' => rand(10, 50),
                    'Overdue' => rand(1, 15),
                ]),
            ]);

            // Monthly Cotisations
            DB::table('statistics')->insert([
                'key' => "admin_monthly_cotisations_$i",
                'value' => json_encode([
                    '6' => [
                        'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        'series' => [
                            [
                                'name' => 'Cotisations',
                                'data' => array_map(
                                    fn() => rand(3000, 12000),
                                    range(1, 6)
                                )
                            ]
                        ]
                    ],
                    '12' => [
                        'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        'series' => [
                            [
                                'name' => 'Cotisations',
                                'data' => array_map(
                                    fn() => rand(3000, 15000),
                                    range(1, 12)
                                )
                            ]
                        ]
                    ],
                ])
            ]);

            // Monthly Expenses
            DB::table('statistics')->insert([
                'key' => "admin_monthly_expenses_$i",
                'value' => json_encode([
                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'series' => [
                        [
                            'name' => 'Expenses',
                            'data' => array_map(
                                fn() => rand(100, 2000),
                                range(1, 6)
                            )
                        ]
                    ]
                ]),
            ]);

            // Contributions by Type
            DB::table('statistics')->insert([
                'key' => "admin_contributions_by_type_$i",
                'value' => json_encode([
                    'Subventions' => rand(1000, 10000),
                    'Donations' => rand(500, 5000),
                    'Cotisations Paid' => rand(5000, 30000),
                ]),
            ]);
        }

        $this->command->info('✅ Admin statistics seeded successfully!');
    }
}
