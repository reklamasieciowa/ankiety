<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'category_id' =>  $faker->biasedNumberBetween($min = 1, $max = 7),
        'question_type_id' => $faker->biasedNumberBetween($min = 1, $max = 4),
        'order' =>  $faker->biasedNumberBetween($min = 1, $max = 100),
        'pl'  => ['name' => $faker->sentence],
        'en'  => ['name' => $faker->sentence.' EN'],
    ];
});
