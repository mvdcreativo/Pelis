<?php

use Faker\Generator as Faker;

$factory->define(App\Movie::class, function (Faker $faker) {

	$title = $faker->sentence(2);
    return [
        //
        'title' => $title,
        'title_origin' => $title, 
        'description' => $faker->text(200), 
        'ano' => rand(2015,2018),
        'duration' => rand(135,190), 
        'image' => $faker->imageUrl($Width=300, $height=500), 
        'rating' => rand(1,10),
        'url_origin' => $faker->imageUrl(), 
        'url_dwl' => $faker->imageUrl(), 
        'state' => rand(0,1), 
        'director_id' => rand(1,20)
    ];
});
