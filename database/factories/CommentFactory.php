<?php

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        "text" => $faker->name,
        "post_id" => factory('App\Post')->create(),
        "author_id" => factory('App\User')->create(),
    ];
});
