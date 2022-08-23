<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Doctor;
use Faker\Generator as Faker;

$factory->define(Doctor::class, function (Faker $faker) {
    return [
        'specialty_id' => $faker->randomElement([11,12]),
        'fee' => $faker->randomElement([1000,1250,1500,750]),
        'note' => $faker->text(100),
        'hospital_id' => 11,
        'created_user_id' => 20001,
        'created_at' => now(),
    ];
});
