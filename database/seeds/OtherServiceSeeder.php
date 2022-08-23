<?php

use Illuminate\Database\Seeder;

class OtherServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('other_services')->insertOrIgnore([
            [
                'id' => 101,
                'name' => 'MRI Scan',
                'fee' => '10000.00',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
            [
                'id' => 102,
                'name' => 'CT Scan',
                'fee' => '10000.00',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
            [
                'id' => 103,
                'name' => 'DEXA Scan',
                'fee' => '5000.00',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
            [
                'id' => 104,
                'name' => 'Mammogram',
                'fee' => '5000.00',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
            [
                'id' => 105,
                'name' => 'Fluoroscopy',
                'fee' => '5000.00',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
        ]);

    }
}
