<?php

$factory->define(App\Evaluation::class, function (Faker\Generator $faker) {
    return [
        "user_id" => factory('App\User')->create(),
        "event_id" => factory('App\Event')->create(),
        "text" => $faker->name,
    ];
});
