<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class HospitalFeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hospital_fees')->insertOrIgnore([
            [
                'hospital_id' => 11,
                'invoice_type_id' => 1,
                'fee' => '100.00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hospital_id' => 11,
                'invoice_type_id' => 2,
                'fee' => '125.00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hospital_id' => 11,
                'invoice_type_id' => 3,
                'fee' => '150.00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hospital_id' => 11,
                'invoice_type_id' => 4,
                'fee' => '175.00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hospital_id' => 12,
                'invoice_type_id' => 1,
                'fee' => '250.00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hospital_id' => 12,
                'invoice_type_id' => 2,
                'fee' => '225.00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hospital_id' => 12,
                'invoice_type_id' => 3,
                'fee' => '250.00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'hospital_id' => 12,
                'invoice_type_id' => 4,
                'fee' => '375.00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
