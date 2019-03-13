<?php

$factory->define(App\Rate::class, function (Faker\Generator $faker) {
    return [
        "session_id" => factory('App\Session')->create(),
        "author_id" => factory('App\User')->create(),
        "type" => collect(["style","content",])->random(),
    ];
});
