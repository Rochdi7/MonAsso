<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class SuperAdminStatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create table if it doesn't exist:
        if (!Schema::hasTable('statistics')) {
            Schema::create('statistics', function ($table) {
                $table->id();
                $table->string('key')->unique();
                $table->json('value');
                $table->timestamps();
            });
        }

        // Safely delete previous records instead of truncate
        DB::table('statistics')->delete();
        DB::statement('ALTER TABLE statistics AUTO_INCREMENT = 1');

        // Member Growth Data
        DB::table('statistics')->insert([
            'key' => 'superadmin_member_growth',
            'value' => json_encode([
                '3' => [
                    'categories' => ['Apr', 'May', 'Jun'],
                    'series' => [
                        ['name' => 'Registrations', 'data' => [
                            rand(80, 200),
                            rand(100, 220),
                            rand(90, 180),
                        ]]
                    ]
                ],
                '6' => [
                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'series' => [
                        ['name' => 'Registrations', 'data' => array_map(fn() => rand(80, 200), range(1, 6))]
                    ]
                ],
                '12' => [
                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    'series' => [
                        ['name' => 'Registrations', 'data' => array_map(fn() => rand(80, 220), range(1, 12))]
                    ]
                ],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Global Cotisation Status
        DB::table('statistics')->insert([
            'key' => 'superadmin_cotisation_status',
            'value' => json_encode([
                'Paid' => rand(5000, 15000),
                'Pending' => rand(300, 1500),
                'Overdue' => rand(100, 800),
                'Rejected' => rand(10, 200),
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Cotisation Cashflow
        DB::table('statistics')->insert([
            'key' => 'superadmin_cotisation_cashflow',
            'value' => json_encode([
                '30' => [
                    'categories' => ['Day 1', 'Day 5', 'Day 10', 'Day 15', 'Day 20', 'Day 25'],
                    'series' => [
                        ['name' => 'Cotisations', 'data' => array_map(fn() => rand(15000, 60000), range(1, 6))]
                    ],
                ],
                '180' => [
                    'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    'series' => [
                        ['name' => 'Cotisations', 'data' => array_map(fn() => rand(120000, 300000), range(1, 6))]
                    ],
                ],
                '365' => [
                    'categories' => ['Q1', 'Q2', 'Q3', 'Q4'],
                    'series' => [
                        ['name' => 'Cotisations', 'data' => array_map(fn() => rand(400000, 800000), range(1, 4))]
                    ],
                ],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Users by Role
        DB::table('statistics')->insert([
            'key' => 'superadmin_users_by_role',
            'value' => json_encode([
                'Members' => rand(5000, 10000),
                'Admins' => rand(30, 70),
                'Board' => rand(50, 200),
                'SuperAdmins' => rand(3, 10),
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Contributions vs Expenses
        DB::table('statistics')->insert([
            'key' => 'superadmin_inflow_outflow',
            'value' => json_encode([
                'Inflow' => rand(50000, 200000),
                'Outflow' => rand(15000, 80000),
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Associations Validated Over Time
        DB::table('statistics')->insert([
            'key' => 'superadmin_associations_validated',
            'value' => json_encode([
                'total' => rand(30, 100),
                'increase_this_year' => rand(5, 20),
                'monthly' => [
                    'Jan' => rand(1, 5),
                    'Feb' => rand(1, 5),
                    'Mar' => rand(1, 5),
                    'Apr' => rand(1, 5),
                    'May' => rand(0, 3),
                    'Jun' => rand(0, 3),
                ]
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✅ SuperAdmin Statistics Seeded Successfully!');
    }
}
