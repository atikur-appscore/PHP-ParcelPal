<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Run::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'date_at' => $faker->unixTime,
        'start_time' => $faker->time,
        'end_time' => $faker->time,
        'start_location' => json_encode(['name' => $faker->cityPrefix, 'unit_number' => $faker->buildingNumber,
            'street_number' => $faker->streetAddress,'street_name' => $faker->streetName,'suburb'=>$faker->citySuffix,
            'state' => $faker->state, 'latitude' => $faker->latitude,'longitude' => $faker->latitude], true),
        'end_location' => json_encode(['name' => $faker->cityPrefix, 'unit_number' => $faker->buildingNumber,
            'street_number' => $faker->streetAddress,'street_name' => $faker->streetName,'suburb'=>$faker->citySuffix,
            'state' => $faker->state, 'latitude' => $faker->latitude,'longitude' => $faker->latitude], true),
        'distance' => $faker->randomNumber(5),
        'user_id' => 2,
    ];
});

$factory->define(App\Parcel::class, function (Faker\Generator $faker) {
    return [
        'run_id' => $faker->numberBetween(1, 20),
        'parcel_id' => $faker->swiftBicNumber,
        'recipient_name' => $faker->name,
        'type' => 'Box',
        'address' => json_encode(['name' => $faker->cityPrefix, 'unit_number' => $faker->buildingNumber,
            'street_number' => $faker->streetAddress,'street_name' => $faker->streetName,'suburb'=>$faker->citySuffix,
            'state' => $faker->state, 'latitude' => $faker->latitude, 'longitude' => $faker->latitude], true),
        'weight' => $faker->numberBetween(10, 100),
        'delivery_instructions' => $faker->text,
        'priority' => 1
    ];
});

$factory->define(App\Favourite::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'unit_number' => $faker->randomNumber(3),
        'street_number' => $faker->randomNumber(3),
        'street_name' => $faker->streetName,
        'suburb' => $faker->citySuffix,
        'state' => $faker->state,
        'latitude' => $faker->latitude,
        'longitude' => $faker->latitude,
        'user_id' => 2,
    ];
});
