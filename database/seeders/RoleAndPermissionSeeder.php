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
            'create cotisation',
            'edit cotisation',
            'delete cotisation',
            'approve cotisation',
            'view cotisations',
            'view meetings', 
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $membre = Role::firstOrCreate(['name' => 'membre', 'guard_name' => 'web']);

        // Super admin gets everything
        $superAdmin->syncPermissions(Permission::all());

        // Admin gets these permissions
        $admin->syncPermissions([
            'manage events',
            'manage cotisations',
            'create cotisation',
            'edit cotisation',
            'delete cotisation',
            'approve cotisation',
            'view dashboard',
            'view meetings', 
        ]);

        // Membre gets limited permissions
        $membre->syncPermissions([
            'participate events',
            'view dashboard',
            'view cotisations',
        ]);
    }
}
