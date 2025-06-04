<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Membre;
use App\Models\Association;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
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

        // Create roles and assign permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $membre = Role::firstOrCreate(['name' => 'membre', 'guard_name' => 'web']);

        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(['manage events', 'manage cotisations', 'view dashboard']);
        $membre->givePermissionTo(['participate events', 'view dashboard']);

        // Create Associations
        $asso1 = Association::firstOrCreate(
            ['email' => 'super@asso.com'],
            [
                'id' => Str::uuid(),
                'name' => 'Asso Super',
                'address' => '123 Rue Super',
                'announcement_status' => 'active',
                'creation_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $asso2 = Association::firstOrCreate(
            ['email' => 'admin@asso.com'],
            [
                'id' => Str::uuid(),
                'name' => 'Asso Admin',
                'address' => '456 Rue Admin',
                'announcement_status' => 'active',
                'creation_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $asso3 = Association::firstOrCreate(
            ['email' => 'membre@asso.com'],
            [
                'id' => Str::uuid(),
                'name' => 'Asso Membre',
                'address' => '789 Rue Membre',
                'announcement_status' => 'active',
                'creation_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Create Membres and assign roles
        $super = Membre::firstOrCreate(
            ['phone' => '0600000001'],
            [
                'id' => Str::uuid(),
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'association_id' => $asso1->id,
            ]
        );
        $super->assignRole('super_admin');

        $adminUser = Membre::firstOrCreate(
            ['phone' => '0600000002'],
            [
                'id' => Str::uuid(),
                'name' => 'Association Admin',
                'password' => Hash::make('password'),
                'association_id' => $asso2->id,
            ]
        );
        $adminUser->assignRole('admin');

        $memberUser = Membre::firstOrCreate(
            ['phone' => '0600000003'],
            [
                'id' => Str::uuid(),
                'name' => 'Regular Member',
                'password' => Hash::make('password'),
                'association_id' => $asso3->id,
            ]
        );
        $memberUser->assignRole('membre');
    }
}
