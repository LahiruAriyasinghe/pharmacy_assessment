<?php

use Illuminate\Database\Seeder;

class LabReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lab_reports')->insertOrIgnore([
            [
                'id' => 61,
                'name' => 'Glucose Level',
                'fee' => '1000.00',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
            [
                'id' => 62,
                'name' => 'hCG - Pregnancy Test',
                'fee' => '1500.00',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
            [
                'id' => 63,
                'name' => 'Lipid Panel',
                'fee' => '2000.00',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
            [
                'id' => 64,
                'name' => 'Urinalysis',
                'fee' => '1000.00',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
            [
                'id' => 65,
                'name' => 'CBC - Complete Blood Count',
                'fee' => '2500.00',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
        ]);
    }
}
