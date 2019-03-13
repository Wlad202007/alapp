<?php

$factory->define(App\Session::class, function (Faker\Generator $faker) {
    return [
        "user_id" => factory('App\User')->create(),
        "event_id" => factory('App\Event')->create(),
        "description" => $faker->name,
        "subject" => $faker->name,
        "time_from" => $faker->date("H:i:s", $max = 'now'),
        "time_to" => $faker->date("H:i:s", $max = 'now'),
    ];
});
