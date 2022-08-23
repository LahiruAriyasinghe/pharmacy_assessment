<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('product_types')->insertOrIgnore([
            [
                'id' => 1,
                'name' => 'Pharmacy',
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Grocery',
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
        ]);
    }
}
