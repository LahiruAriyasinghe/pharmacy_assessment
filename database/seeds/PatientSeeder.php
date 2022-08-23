<?php

use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('patients')->insertOrIgnore([
            [
                'id' => 1,
                'first_name' => 'Kasun Perera',
                'contact' => '0777123456',
                'gender' => 'M',
                'age' => '24',
                'hospital_id' => 12,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'first_name' => 'Sunil Silva',
                'contact' => '0777111222',
                'gender' => 'M',
                'age' => '35',
                'hospital_id' => 12,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
        ]);
    }
}
