<?php

$factory->define(App\Note::class, function (Faker\Generator $faker) {
    return [
        "author_id" => factory('App\User')->create(),
        "text" => $faker->name,
    ];
});
