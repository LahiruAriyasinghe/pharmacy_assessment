<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PharmacistRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view product']);
        Permission::create(['name' => 'create product']);
        Permission::create(['name' => 'edit product']);
        Permission::create(['name' => 'delete product']);

        // create roles and assign created permissions
        $superRole = Role::findByName('super-admin');
        $superRole->givePermissionTo(Permission::all());
        $superRole->save();
        
        $adminRole = Role::findByName('asiri-admin');
        $adminRole->givePermissionTo(['view product', 'create product', 'edit product', 'delete product',]);
        $adminRole->save();

        $role = Role::create(['name' => 'asiri-pharmacist', 'guard_name' => 'web', 'hospital_id' => 11])
        ->givePermissionTo([
            'view doctor',
            'view lab report',
            'view service',
            'view session',
            'view patient', 'create patient', 'edit patient',
            'create invoice',
            'view product', 'create product', 'edit product',  'delete product',
        ]);

    }
}