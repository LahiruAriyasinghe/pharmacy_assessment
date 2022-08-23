<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insertOrIgnore([
            [
                'id' => 20000,
                'first_name' => 'Ayubo Health Admin',
                'username' => 'ayuboadmin',
                'email' => 'ayuboadmin@mailinator.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'contact' => '0111234567',
                'hospital_id' => null,
                'created_user_id' => null,
                'created_at' => now(),
            ],
            [
                'id' => 20001,
                'first_name' => 'Asiri Hospital Admin',
                'username' => 'asiriadmin',
                'email' => 'asiriadmin@mailinator.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'contact' => '0123456789',
                'hospital_id' => 11,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
            [
                'id' => 20002,
                'first_name' => 'Hemas Hospital Admin',
                'username' => 'hemasadmin',
                'email' => 'hemasadmin@mailinator.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'contact' => '0123456789',
                'hospital_id' => 12,
                'created_user_id' => 20000,
                'created_at' => now(),
            ],
        ]);

        DB::table('model_has_roles')->insertOrIgnore([
            [
                'role_id' => 1,
                'model_type' => 'App\User',
                'model_id' => 20000,
            ],
            [
                'role_id' => 2,
                'model_type' => 'App\User',
                'model_id' => 20001,
            ],
            [
                'role_id' => 6,
                'model_type' => 'App\User',
                'model_id' => 20002,
            ],
        ]);

        factory(App\User::class, 10)->create()->each(function ($user) {
            $user->assignRole(3);
            $user->doctor()->save(factory(App\Doctor::class)->make());
        });
    }
}
