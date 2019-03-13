<?php

$factory->define(App\Sponsor::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "description" => $faker->name,
        "website" => $faker->name,
    ];
});
