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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'manage associations',
            'manage events',
            'participate events',
            'manage cotisations',
            'view dashboard',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $membre = Role::firstOrCreate(['name' => 'membre']);

        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(['manage events', 'manage cotisations', 'view dashboard']);
        $membre->givePermissionTo(['participate events', 'view dashboard']);

        // Create dummy associations (using correct column names)
        $asso1 = Association::create([
            'id' => Str::uuid(),
            'name' => 'Asso Super',
            'address' => '123 Rue Super',
            'email' => 'super@asso.com',
            'announcement_status' => 'active',
            'creation_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $asso2 = Association::create([
            'id' => Str::uuid(),
            'name' => 'Asso Admin',
            'address' => '456 Rue Admin',
            'email' => 'admin@asso.com',
            'announcement_status' => 'active',
            'creation_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $asso3 = Association::create([
            'id' => Str::uuid(),
            'name' => 'Asso Membre',
            'address' => '789 Rue Membre',
            'email' => 'membre@asso.com',
            'announcement_status' => 'active',
            'creation_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create test users linked to the correct association
        $super = Membre::create([
            'id' => Str::uuid(),
            'name' => 'Super Admin',
            'phone' => '0600000001',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'association_id' => $asso1->id,
        ]);
        $super->assignRole('super_admin');

        $adminUser = Membre::create([
            'id' => Str::uuid(),
            'name' => 'Association Admin',
            'phone' => '0600000002',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'association_id' => $asso2->id,
        ]);
        $adminUser->assignRole('admin');

        $memberUser = Membre::create([
            'id' => Str::uuid(),
            'name' => 'Regular Member',
            'phone' => '0600000003',
            'password' => Hash::make('password'),
            'role' => 'membre',
            'association_id' => $asso3->id,
        ]);
        $memberUser->assignRole('membre');
    }
}
