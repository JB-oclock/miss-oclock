<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Performance;
use Faker\Generator as Faker;

$factory->define(Performance::class, function (Faker $faker) {
    return [
        'title' => $faker->word()
    ];
});
