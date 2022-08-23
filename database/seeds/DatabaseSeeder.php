<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            HospitalSeeder::class,
            RolesPermissionsSeeder::class,
            // PharmacistRoleSeeder::class,
            SpecialtySeeder::class,
            UserSeeder::class,
            PatientSeeder::class,
            InvoiceTypeSeeder::class,
            HospitalFeesSeeder::class,
            // LabReportSeeder::class,
            OtherServiceSeeder::class,
            ProductTypeSeeder::class,
            // ProductSeeder::class,
            // ProductStockSeeder::class,
            LabReportTestDataSeeder::class,
        ]);
    }
}
