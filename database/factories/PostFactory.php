<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'slug' =>$this->faker->slug(2, true),
        'content' => $this->faker->paragraph(),
        'image' => $faker->image('public/storage', 640, 480, null, false),
        'tags' => 'hashtag',
        'status' => $this->faker->randomElement([Post::DRAFT, Post::PUBLISHED])
    ];
});
