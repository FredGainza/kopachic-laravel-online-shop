<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Shop;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Shop::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2),
        'address' => $faker->address,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'holder' => strtoupper($faker->sentence(3)),
        'bic' => strtoupper(Str::random(8)),
        'iban' => $faker->iban,
        'bank' => $faker->sentence(2),
        'bank_address' => $faker->address,
        'facebook' => $faker->url,
        'home' => $faker->sentence(3),
        'home_infos' => $faker->text,
        'home_shipping' => $faker->text,
    ];
});
