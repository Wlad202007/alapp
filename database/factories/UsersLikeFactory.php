<?php

$factory->define(App\UsersLike::class, function (Faker\Generator $faker) {
    return [
        "author_id" => factory('App\User')->create(),
        "user_id" => factory('App\User')->create(),
        "text" => $faker->name,
    ];
});
