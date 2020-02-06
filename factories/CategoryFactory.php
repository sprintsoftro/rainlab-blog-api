  
<?php

use Faker\Generator;
use RainLab\Blog\Models\Category;
use Carbon\Carbon;

/*
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(Category::class, function (Generator $faker) {
    return [
        'description' => $faker->paragraph(),
        'name' => $faker->words(rand(2, 4), true),
        'slug' => $faker->slug,
    ];
});
