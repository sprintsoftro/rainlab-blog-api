  
<?php

use Faker\Generator;
use RainLab\Blog\Models\Post;
use Carbon\Carbon;

/*
 * @var $factory Illuminate\Database\Eloquent\Factory
 */
$factory->define(Post::class, function (Generator $faker) {
    return [
        'content' => $faker->paragraph(),
        'published' => '1',
        'published_at' => Carbon::yesterday()->format('Y-m-d H:i:s'),
        'slug' => $faker->slug,
        'title' => $faker->sentence(5),
    ];
});
