<?php

$factory->define(App\Planner::class, function (Faker\Generator $faker) {
    return [
        "time" => $faker->date("d.m.Y H:i:s", $max = 'now'),
        "body" => $faker->name,
        "done" => 0,
        "author_id" => factory('App\User')->create(),
    ];
});
