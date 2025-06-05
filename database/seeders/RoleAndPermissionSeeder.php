<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage associations',
            'manage events',
            'participate events',
            'manage cotisations',
            'view dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $membre = Role::firstOrCreate(['name' => 'membre', 'guard_name' => 'web']);

        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(['manage events', 'manage cotisations', 'view dashboard']);
        $membre->givePermissionTo(['participate events', 'view dashboard']);
    }
}
