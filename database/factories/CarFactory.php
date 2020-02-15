<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Car;
use Faker\Generator as Faker;

$factory->define(Car::class, function (Faker $faker) {

    $faker->addProvider(new \Faker\Provider\Fakecar($faker));

    return [
        'model' => $faker->vehicleModel,
        'registration_plate' => $faker->vehicleRegistration,
        'door_number' => $faker->vehicleDoorCount
    ];
});
