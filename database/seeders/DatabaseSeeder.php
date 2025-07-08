<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Core seeders
            RoleAndPermissionSeeder::class,
            UserAndAssociationSeeder::class,

            // Dashboard seeders
            SuperAdminDashboardSeeder::class,
            AdminDashboardSeeder::class,
            BoardDashboardSeeder::class,
            SupervisorDashboardSeeder::class,
            MemberDashboardSeeder::class,

            // Statistics seeders
            // SuperAdminStatisticsSeeder::class,
            // AdminStatisticsSeeder::class,
            // BoardStatisticsSeeder::class,
            // SupervisorStatisticsSeeder::class,
            // MemberStatisticsSeeder::class,
        ]);
    }
}
