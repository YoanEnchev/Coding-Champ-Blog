<?php

use Faker\Generator as Faker;
use App\Helpers\NameHelper as NameHelper;

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

$factory->define(App\Models\Tag::class, function (Faker $faker) {
    
    $name = $faker->unique()->name;
    
    return [
        'pretty_name' => $name,
        'url_name' => NameHelper::makeNameUrlFriendly($name)
    ];
});
