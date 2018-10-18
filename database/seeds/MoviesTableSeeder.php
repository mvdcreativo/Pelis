<?php

use Illuminate\Database\Seeder;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Movie::class, 100)->create()->each( function(App\Movie $movie){
        	$movie->actors()->attach([
        		rand(1,10),
        		rand(11,20),
        		rand(21,30),
        		rand(31,40),
        		rand(41,50)
        	]);

        	$movie->genres()->attach([
        		rand(1,2),
        		rand(3,6),
        		rand(7,10)
        	]);
        });


    }
}
