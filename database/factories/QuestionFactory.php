<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title' => rtrim($faker->sentence(5, 10), "."),
        'body' => $faker->paragraphs(rand(3, 7), true),
        'views' => rand(0,1000),
        'answers_count' => rand(0,10),
        'votes' => rand(-100,100),
    ];
});
