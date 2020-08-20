<?php

/** @var Factory $factory */

use App\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(
    Category::class,
    static function (Faker $faker) {
        return [
            'name'        => $faker->name,
            'parent_id'   => $faker->randomDigit,
            'external_id' => $faker->randomDigit,
        ];
    }
);
