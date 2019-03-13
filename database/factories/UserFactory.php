<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "description" => $faker->name,
        "company" => $faker->name,
        "job" => $faker->name,
        "phone" => $faker->name,
        "email" => $faker->safeEmail,
        "password" => str_random(10),
        "remember_token" => $faker->name,
    ];
});
