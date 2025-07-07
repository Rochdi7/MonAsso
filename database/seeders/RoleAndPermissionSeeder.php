<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Association;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage roles',
            'manage permissions',
            'manage associations',

            'view events',
            'create events',
            'edit events',
            'delete events',
            'participate events',

            'view cotisations',
            'create cotisation',
            'edit cotisation',
            'delete cotisation',
            'approve cotisation',

            'view meetings',
            'create meetings',
            'edit meetings',
            'delete meetings',

            'view members',
            'create members',
            'edit members',
            'delete members',

            'view contributions',
            'create contributions',
            'edit contributions',
            'delete contributions',

            'view expenses',
            'create expenses',
            'edit expenses',
            'delete expenses',

            'view dashboard',
            'view statistics',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $roles = [
            'superadmin',
            'admin',
            'board',
            'supervisor',
            'member',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        // Assign permissions to each role
        Role::findByName('superadmin')->syncPermissions(Permission::all());

        Role::findByName('admin')->syncPermissions([
            'view dashboard',
            'view events',
            'create events',
            'edit events',
            'delete events',
            'participate events',
            'view cotisations',
            'create cotisation',
            'edit cotisation',
            'delete cotisation',
            'approve cotisation',
            'view meetings',
            'create meetings',
            'edit meetings',
            'delete meetings',
            'view members',
            'create members',
            'edit members',
            'delete members',
            'view contributions',
            'create contributions',
            'edit contributions',
            'delete contributions',
            'view expenses',
            'create expenses',
            'edit expenses',
            'delete expenses',
            'view statistics',
        ]);

        Role::findByName('board')->syncPermissions([
            'view dashboard',
            'view events',
            'create events',
            'edit events',
            'participate events',
            'view cotisations',
            'create cotisation',
            'edit cotisation',
            'approve cotisation',
            'view meetings',
            'create meetings',
            'edit meetings',
            'view members',
            'create members',
            'edit members',
            'view contributions',
            'create contributions',
            'edit contributions',
            'view expenses',
            'create expenses',
            'edit expenses',
            'view statistics',
        ]);

        Role::findByName('supervisor')->syncPermissions([
            'view dashboard',
            'view members',
            'create members',
            'view meetings',
            'create meetings',
            'delete meetings',
            'view statistics',
        ]);

        Role::findByName('member')->syncPermissions([
            'view dashboard',
            'view cotisations',
            'view events',
            'participate events',
            'view meetings',
            'view statistics',
        ]);

        // Create a default association if not exists
        $association = Association::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Default Association',
                'email' => 'default@asso.com',
                'address' => '123 Main Street, Casablanca',
                'is_validated' => true,
            ]
        );

        // Create default users for testing
        $users = [
            'superadmin' => 'super@asso.com',
            'admin' => 'admin@asso.com',
            'board' => 'board@asso.com',
            'supervisor' => 'supervisor@asso.com',
            'member' => 'member@asso.com',
        ];

        foreach ($users as $role => $email) {
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => ucfirst($role),
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'phone' => '0600000000',
                    'association_id' => $association->id,
                ]
            );

            $user->assignRole($role);

            // Optionally sync permissions directly for testing
            $roleModel = Role::findByName($role);
            $user->syncPermissions($roleModel->permissions);
        }

        // Clear cache again to ensure fresh runtime permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
