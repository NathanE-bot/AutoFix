<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(User::class, function (Faker $faker) {
    return [
        'fullName' => $faker->name,
        'displayName' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $faker->unique()->password, // password
        'DoB' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'phoneNumber' => $faker->e164PhoneNumber,
        'address' => $faker->address,
        'role' => $faker->numberBetween($min = 1, $max = 3),
        'profilePicture' => '',
        'isActive' => '1',
        'email_verified_at' => now(),
    ];
});
