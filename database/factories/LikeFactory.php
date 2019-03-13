<?php

$factory->define(App\Like::class, function (Faker\Generator $faker) {
    return [
        "author_id" => factory('App\User')->create(),
        "post_id" => factory('App\Post')->create(),
    ];
});
