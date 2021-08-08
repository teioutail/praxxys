<?php

namespace Database\Factories;

use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker){
    return [
        'name' => $faker->name(),
        'category' => 'Manga',
        'description' => $faker->paragraph(),
        'date_time' => null
    ];
});