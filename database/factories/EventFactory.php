<?php

$factory->define(App\Event::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "description" => $faker->name,
        "date_from" => $faker->date("d.m.Y", $max = 'now'),
        "date_to" => $faker->date("d.m.Y", $max = 'now'),
        "web_url" => $faker->name,
        "industry_id" => factory('App\Industry')->create(),
    ];
});
