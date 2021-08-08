<?php

// namespace Database\Factories;

// use Faker\Generator as Faker;

// $factory->define(\App\Product::class, function (Faker $faker){
//     return [
//         'name' => $faker->name(),
//         'category' => 'Manga',
//         'description' => $faker->paragraph(),
//         'date_time' => null
//     ];
// });

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'name' => $this->faker->name(),
        'category' => 'Manga',
        'description' => $this->faker->paragraph(),
        'date_time' => $this->faker->dateTime() 
        ];
    }
}