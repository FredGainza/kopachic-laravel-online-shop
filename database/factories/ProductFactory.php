<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3),
        'price' => mt_rand(100, 1000) / 10.0,
        'weight' => mt_rand(1, 4) / 1.8,
        'quantity' => 50,
        'active' => $faker->boolean(),
        'image' => strval(mt_rand(1, 5)) . '.jpg',
        'description' => $faker->paragraph(),
    ];
});
