<?php

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        "event_id" => factory('App\Event')->create(),
        "author_id" => factory('App\User')->create(),
        "body" => $faker->name,
    ];
});
