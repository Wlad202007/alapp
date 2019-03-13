<?php

$factory->define(App\Answer::class, function (Faker\Generator $faker) {
    return [
        "session_id" => factory('App\Session')->create(),
        "question_id" => factory('App\Answer')->create(),
        "author_id" => factory('App\User')->create(),
        "text" => $faker->name,
    ];
});
