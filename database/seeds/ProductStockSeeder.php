<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * 
     */

 
    public function run()
    {
        DB::table('product_stocks')->insertOrIgnore([
            [
                'id' => 1,
                'product_id' => 1,
                'batch_no' => '10203040',
                'sell_price' => 10.00,
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'product_id' => 1,
                'batch_no' => '10203041',
                'sell_price' => 20.00,
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'product_id' => 2,
                'batch_no' => '10203042',
                'sell_price' => 30.00,
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
        ]);
    }
}
