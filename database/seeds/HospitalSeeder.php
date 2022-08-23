<?php

use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hospitals')->insertOrIgnore([
            [
                'id' => 11,
                'name' => 'Asiri Hospital',
                'username' => 'asiri',
                'address' => 'No 1, Main Street, Colombo 08',
                'contact' => '0777112233',
                'created_at' => now(),
            ],
            [
                'id' => 12,
                'name' => 'Hemas Hospital',
                'username' => 'hemas',
                'address' => 'No 2, Church Square, Colombo 09',
                'contact' => '0777321321',
                'created_at' => now(),
            ],
        ]);

    }
}
