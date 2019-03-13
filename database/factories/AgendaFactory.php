<?php

$factory->define(App\Agenda::class, function (Faker\Generator $faker) {
    return [
        "event_id" => factory('App\Event')->create(),
        "time" => $faker->date("H:i:s", $max = 'now'),
        "text" => $faker->name,
    ];
});
