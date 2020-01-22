<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    return [
        'title' => $faker->word(),
        'answer_1' => $faker->word(),
        'answer_2' => $faker->word(),
        'answer_3' => $faker->word(),
        'answer_good' => $faker->word(),
    ];
});
