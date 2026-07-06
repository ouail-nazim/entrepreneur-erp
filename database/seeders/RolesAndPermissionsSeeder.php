<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        \Spatie\Permission\Models\Permission::create(['name' => 'manage contacts']);
        \Spatie\Permission\Models\Permission::create(['name' => 'manage timesheets']);
        \Spatie\Permission\Models\Permission::create(['name' => 'validate timesheets']);
        \Spatie\Permission\Models\Permission::create(['name' => 'manage inventory']);
        \Spatie\Permission\Models\Permission::create(['name' => 'manage invoices']);
        \Spatie\Permission\Models\Permission::create(['name' => 'manage settings']);

        // create roles and assign existing permissions
        $roleAdmin = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo(\Spatie\Permission\Models\Permission::all());

        $roleManager = \Spatie\Permission\Models\Role::create(['name' => 'manager']);
        $roleManager->givePermissionTo(['manage contacts', 'manage timesheets', 'manage inventory', 'manage invoices']);

        $roleViewer = \Spatie\Permission\Models\Role::create(['name' => 'viewer']);
        $roleViewer->givePermissionTo(['manage contacts', 'manage inventory']);
    }
}
