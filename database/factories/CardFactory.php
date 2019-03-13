<?php

$factory->define(App\Card::class, function (Faker\Generator $faker) {
    return [
        "author_id" => factory('App\User')->create(),
        "body" => $faker->name,
    ];
});
