<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Association;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cached roles/permissions from Spatie package.
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define ALL possible permissions that will be created in the system.
        $permissions = [
            'manage roles', // For Superadmin only to manage roles
            'manage permissions', // For Superadmin only to manage permissions
            'manage associations', // For Superadmin only to manage associations

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

            'view dashboard', // General dashboard access
        ];

        // Create or find each defined permission.
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web', // Default guard for web authentication
            ]);
        }

        // Define roles that will be created in the system.
        $roles = [
            'superadmin',
            'admin',
            'board',
            'supervisor',
            'member',
        ];

        // Create or find each defined role.
        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web', // Default guard for web authentication
            ]);
        }

        // Assign permissions to roles
        // -----------------------------

        // 1. Super Admin: Can do everything.
        Role::findByName('superadmin')->syncPermissions(Permission::all());

        // 2. Admin: Can manage only his association's data (full CRUD).
        Role::findByName('admin')->syncPermissions([
            'view dashboard',
            'view events', 'create events', 'edit events', 'delete events', 'participate events',
            'view cotisations', 'create cotisation', 'edit cotisation', 'delete cotisation', 'approve cotisation',
            'view meetings', 'create meetings', 'edit meetings', 'delete meetings',
            'view members', 'create members', 'edit members', 'delete members',
            'view contributions', 'create contributions', 'edit contributions', 'delete contributions',
            'view expenses', 'create expenses', 'edit expenses', 'delete expenses',
        ]);

        // 3. Board: Same as admin but WITHOUT deleting data (can add and edit).
        Role::findByName('board')->syncPermissions([
            'view dashboard',
            'view events', 'create events', 'edit events', 'participate events', // No 'delete events'
            'view cotisations', 'create cotisation', 'edit cotisation', 'approve cotisation', // No 'delete cotisation'
            'view meetings', 'create meetings', 'edit meetings', // No 'delete meetings'
            'view members', 'create members', 'edit members', // No 'delete members'
            'view contributions', 'create contributions', 'edit contributions', // No 'delete contributions'
            'view expenses', 'create expenses', 'edit expenses', // No 'delete expenses'
        ]);

        // 4. Supervisor: Can only add members & meetings (and view dashboard).
        Role::findByName('supervisor')->syncPermissions([
            'view dashboard',
            'view members', 'create members', // Can view and create members
            'view meetings', 'create meetings', // Can view and create meetings
        ]);

        // 5. Member: Can view only his cotisations, events, and meetings.
        Role::findByName('member')->syncPermissions([
            'view dashboard',
            'view cotisations',
            'view events',
            'participate events',
            'view meetings',
        ]);

        // -----------------------------
        // Ensure core associations and users are seeded.
        // This part can be shared or split with UserAndAssociationSeeder as per your preference.
        // For simplicity and to avoid duplicates, I'm keeping primary users here.

        $association = Association::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Default Association',
                'email' => 'default@asso.com',
                'address' => '123 Main Street, Casablanca',
                'is_validated' => true,
            ]
        );

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
                    'association_id' => $association->id, // Assign to default association
                ]
            );
            $user->assignRole($role);
        }

        // Example: Create additional admins/users for other associations in UserAndAssociationSeeder
        // (as provided in the previous turn)
    }
}
