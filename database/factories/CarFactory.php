<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Car;
use Faker\Generator as Faker;

$factory->define(Car::class, function (Faker $faker) {
    return [
        'model' => $faker->regexify('('.$faker->colorName.'|'.$faker->firstNameMale.'|'.$faker->firstNameMale.')'),
        'registration_plate' => strtoupper($faker->unique()->bothify('#### ???')),
        'seat_number' => $faker->regexify('(3|5)')
    ];
});
