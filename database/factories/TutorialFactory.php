<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Tutorial::class, function (Faker $faker) {
    return [
        'keywords' => 'keyword 1, keyword 2, keyword 3',
        'description' => $faker->text,
        'priority' => $faker->numberBetween(1, 30)
    ];
});
