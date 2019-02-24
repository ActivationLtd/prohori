<?php

use Faker\Generator as Faker;

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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker $faker) {
    $first_name = $faker->firstName;
    $last_name = $faker->lastName;
    $group_ids_csv = random_int(4, 5);
    return [
        'name' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => 'activation', // secret
        'remember_token' => str_random(10),
        'email_verified_at' => now(),
        'first_name' => $first_name,
        'last_name' => $last_name,
        'full_name' => $first_name . " " . $last_name,
        'group_ids_csv' => $group_ids_csv,
        'is_active' => 1,
        'profile_pic_url' => $faker->imageUrl(250,250),
    ];
});
