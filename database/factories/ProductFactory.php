<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;


$factory->define(\App\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->text,
        'count' => rand(1 ,100),
        'is_active' => true,
        'category_id' => \App\Category::create([ 'name' => 'cat1'])->id
    ];
});
