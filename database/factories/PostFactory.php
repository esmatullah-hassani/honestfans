<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'video_path' => "video.mp4",
        'description' => "This is the post ".$faker->unique(true)->numberBetween(1,3),
    ];
});
