<?php

/** @var Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(
    Product::class,
    function (Faker $faker) {
        return [
            'name'        => $faker->name,
            'description' => $faker->words(100, true),
            'price'       => $faker->randomDigit,
            'quantity'    => $faker->randomDigit,
            'external_id' => $faker->randomDigit,
        ];
    }
);
