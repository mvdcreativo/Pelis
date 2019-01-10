<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenresMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genres_movies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('genre_id')->unsigned();
            $table->integer('movie_id')->unsigned();
            $table->timestamps();


            //relaciones.

            $table->foreign('genre_id')->references('id')->on('genres')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                    
            $table->foreign('movie_id')->references('id')->on('movies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            
        });

        
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genres_movies');
    }
}
