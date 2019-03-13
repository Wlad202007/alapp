<?php

$factory->define(App\Message::class, function (Faker\Generator $faker) {
    return [
        "body" => $faker->name,
        "author_id" => factory('App\User')->create(),
        "group_id" => factory('App\Event')->create(),
        "read" => 0,
    ];
});
