<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
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
        Permission::create(['name' => 'view user', 'category' => 'user']);
        Permission::create(['name' => 'create user', 'category' => 'user']);
        Permission::create(['name' => 'edit user', 'category' => 'user']);
        Permission::create(['name' => 'delete user', 'category' => 'user']);

        Permission::create(['name' => 'view role', 'category' => 'role']);
        Permission::create(['name' => 'create role', 'category' => 'role']);
        Permission::create(['name' => 'edit role', 'category' => 'role']);
        Permission::create(['name' => 'delete role', 'category' => 'role']);

        Permission::create(['name' => 'view doctor', 'category' => 'doctor']);
        Permission::create(['name' => 'create doctor', 'category' => 'doctor']);
        Permission::create(['name' => 'edit doctor', 'category' => 'doctor']);
        Permission::create(['name' => 'delete doctor', 'category' => 'doctor']);

        Permission::create(['name' => 'view lab report']);
        Permission::create(['name' => 'create lab report']);
        Permission::create(['name' => 'edit lab report']);
        Permission::create(['name' => 'delete lab report']);

        Permission::create(['name' => 'view service', 'category' => 'other service']);
        Permission::create(['name' => 'create service', 'category' => 'other service']);
        Permission::create(['name' => 'edit service', 'category' => 'other service']);
        Permission::create(['name' => 'delete service', 'category' => 'other service']);

        Permission::create(['name' => 'view session', 'category' => 'chanel session']);
        Permission::create(['name' => 'create session', 'category' => 'chanel session']);
        Permission::create(['name' => 'edit session', 'category' => 'chanel session']);
        Permission::create(['name' => 'delete session', 'category' => 'chanel session']);

        Permission::create(['name' => 'view patient', 'category' => 'patient']);
        Permission::create(['name' => 'create patient', 'category' => 'patient']);
        Permission::create(['name' => 'edit patient', 'category' => 'patient']);
        Permission::create(['name' => 'delete patient', 'category' => 'patient']);

        Permission::create(['name' => 'view product', 'category' => 'pharmacy product']);
        Permission::create(['name' => 'create product', 'category' => 'pharmacy product']);
        Permission::create(['name' => 'edit product', 'category' => 'pharmacy product']);
        Permission::create(['name' => 'delete product', 'category' => 'pharmacy product']);

        Permission::create(['name' => 'view unit', 'category' => 'lab report']);
        Permission::create(['name' => 'create unit', 'category' => 'lab report']);
        Permission::create(['name' => 'edit unit', 'category' => 'lab report']);
        Permission::create(['name' => 'delete unit', 'category' => 'lab report']);

        Permission::create(['name' => 'view result category', 'category' => 'lab report']);
        Permission::create(['name' => 'create result category', 'category' => 'lab report']);
        Permission::create(['name' => 'edit result category', 'category' => 'lab report']);
        Permission::create(['name' => 'delete result category', 'category' => 'lab report']);

        Permission::create(['name' => 'view test data', 'category' => 'lab report']);
        Permission::create(['name' => 'create test data', 'category' => 'lab report']);
        Permission::create(['name' => 'edit test data', 'category' => 'lab report']);
        Permission::create(['name' => 'delete test data', 'category' => 'lab report']);

        Permission::create(['name' => 'view test data category', 'category' => 'lab report']);
        Permission::create(['name' => 'create test data category', 'category' => 'lab report']);
        Permission::create(['name' => 'edit test data category', 'category' => 'lab report']);
        Permission::create(['name' => 'delete test data category', 'category' => 'lab report']);

        Permission::create(['name' => 'view patient lab report', 'category' => 'lab report']);
        Permission::create(['name' => 'update patient lab report', 'category' => 'lab report']);
        Permission::create(['name' => 'print patient lab report', 'category' => 'lab report']);

        Permission::create(['name' => 'create invoice', 'category' => 'invoice']);
        Permission::create(['name' => 'reverse invoice', 'category' => 'invoice']);

        Permission::create(['name' => 'view all cash reports', 'category' => 'reports']);

        Permission::create(['name' => 'reset user password', 'category' => 'user']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'asiri-admin', 'guard_name' => 'web', 'hospital_id' => 11])
            ->givePermissionTo([
                'view user', 'create user', 'edit user', 'delete user',
                'view doctor', 'create doctor', 'edit doctor', 'delete doctor',
                'view role', 'create role', 'edit role', 'delete role',
                'view lab report', 'create lab report', 'edit lab report', 'delete lab report',
                'view service', 'create service', 'edit service', 'delete service',
                'view session', 'create session', 'edit session', 'delete session',
                'view patient', 'create patient', 'edit patient', 'delete patient',
                'view patient lab report', 'print patient lab report', 'update patient lab report',
                'view product', 'create product', 'edit product', 'delete product',
                'create invoice', 'reverse invoice',
                'view all cash reports',
                'reset user password',
                'view unit', 'create unit', 'edit unit', 'delete unit',
                'view result category', 'create result category', 'edit result category', 'delete result category',
                'view test data', 'create test data', 'edit test data', 'delete test data',
                'view test data category', 'create test data category', 'edit test data category', 'delete test data category',
            ]);

        $role = Role::create(['name' => 'asiri-physician', 'guard_name' => 'web', 'hospital_id' => 11])
            ->givePermissionTo([
                'view doctor',
                'view lab report', 'create lab report', 'edit lab report', 'delete lab report',
                'view service', 'create service', 'edit service', 'delete service',
                'view session', 'create session', 'edit session', 'delete session',
                'view patient', 'create patient', 'edit patient', 'delete patient',
                'view patient lab report', 'print patient lab report', 'update patient lab report',
                'view product', 'create product', 'edit product', 'delete product',
                'create invoice',
            ]);

        $role = Role::create(['name' => 'asiri-receptionist', 'guard_name' => 'web', 'hospital_id' => 11])
            ->givePermissionTo([
                'view doctor',
                'view lab report',
                'view service',
                'view session',
                'view patient', 'create patient', 'edit patient',
                'view patient lab report', 'print patient lab report',
                'create invoice',
            ]);

        $role = Role::create(['name' => 'asiri-pharmacist', 'guard_name' => 'web', 'hospital_id' => 11])
            ->givePermissionTo([
                'view doctor',
                'view lab report',
                'view service',
                'view session',
                'view patient', 'create patient', 'edit patient',
                'create invoice',
                'view product', 'create product', 'edit product', 'delete product',
            ]);

        $role = Role::create(['name' => 'hemas-admin', 'guard_name' => 'web', 'hospital_id' => 12])
            ->givePermissionTo([
                'view user', 'create user', 'edit user', 'delete user',
                'view doctor', 'create doctor', 'edit doctor', 'delete doctor',
                'view role', 'create role', 'edit role', 'delete role',
                'view lab report', 'create lab report', 'edit lab report', 'delete lab report',
                'view service', 'create service', 'edit service', 'delete service',
                'view session', 'create session', 'edit session', 'delete session',
                'view patient', 'create patient', 'edit patient', 'delete patient',
                'view patient lab report', 'print patient lab report', 'update patient lab report',
                'view product', 'create product', 'edit product', 'delete product',
                'create invoice', 'reverse invoice',
                'view all cash reports',
                'reset user password',
                'view unit', 'create unit', 'edit unit', 'delete unit',
                'view result category', 'create result category', 'edit result category', 'delete result category',
                'view test data', 'create test data', 'edit test data', 'delete test data',
                'view test data category', 'create test data category', 'edit test data category', 'delete test data category',
            ]);

        $role = Role::create(['name' => 'hemas-physician', 'guard_name' => 'web', 'hospital_id' => 12])
            ->givePermissionTo([
                'view lab report', 'create lab report', 'edit lab report', 'delete lab report',
                'view service', 'create service', 'edit service', 'delete service',
                'view session', 'create session', 'edit session', 'delete session',
                'view patient', 'create patient', 'edit patient', 'delete patient',
                'view patient lab report', 'print patient lab report', 'update patient lab report',
                'view product', 'create product', 'edit product', 'delete product',
                'create invoice',
            ]);

        $role = Role::create(['name' => 'hemas-receptionist', 'guard_name' => 'web', 'hospital_id' => 12])
            ->givePermissionTo([
                'view patient', 'create patient', 'edit patient',
                'view patient lab report', 'print patient lab report',
                'create invoice',
            ]);

        $role = Role::create(['name' => 'asiri-mlt', 'guard_name' => 'web', 'hospital_id' => 11])
            ->givePermissionTo([
                'view lab report',
                'view unit', 'create unit', 'edit unit',
                'view result category', 'create result category', 'edit result category',
                'view test data', 'create test data', 'edit test data',
                'view test data category', 'create test data category', 'edit test data category', 'delete test data category',
            ]);
    }
}
