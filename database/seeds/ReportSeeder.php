<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('report_types')->insertOrIgnore([
            [
                'id' => 3001,
                'name' => 'Blood Urea',
                'fee' => 1500,
                'hospital_id' => 11,
                'created_user_id' => 20001,
                'created_at' => now(),
            ],
            [
                'id' => 3002,
                'name' => 'Thyroid Profile',
                'fee' => 2500,
                'hospital_id' => 11,
                'created_user_id' => 20001,
                'created_at' => now(),
            ],
            [
                'id' => 3003,
                'name' => 'Lipid Profile',
                'fee' => 2500,
                'hospital_id' => 11,
                'created_user_id' => 20001,
                'created_at' => now(),
            ],
           
        ]);
    }
}
