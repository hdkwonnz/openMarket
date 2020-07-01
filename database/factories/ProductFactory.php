<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->text(15),
        'price' => $faker->numberBetween(15.10, 300.99),
        'image' => 'https://via.placeholder.com/200x250',
        'option' => $faker->numberBetween(2, 2),
    ];
});
