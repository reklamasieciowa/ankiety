<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'survey_id' =>  1,
        'post_id' => $faker->biasedNumberBetween($min = 1, $max = 7),
        'department_id' => $faker->biasedNumberBetween($min = 1, $max = 17),
        'industry_id' => $faker->biasedNumberBetween($min = 1, $max = 15),
    ];
});
