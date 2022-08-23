<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insertOrIgnore([
            [
                'id' => 1,
                'name' => 'Panadol',
                'product_type_id' => 1,
                'uom' => 'U',
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Piriton',
                'product_type_id' => 1,
                'uom' => 'U',
                'hospital_id' => 11,
                'created_user_id' => 20002,
                'created_at' => now(),
            ],
        ]);
    }
}
