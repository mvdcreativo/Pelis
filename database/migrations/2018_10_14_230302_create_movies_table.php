<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tmdb_id')->nullable();
            $table->string('title');
            $table->string('slug', 128)->nullable();
            $table->string('backdrop_path')->nullable();
            $table->integer('budget')->nullable();
            $table->string('imdb_id')->nullable();
            $table->string('original_language')->nullable();
            $table->string('original_title')->nullable();
            $table->text('overview')->nullable();
            $table->float('popularity')->nullable();
            $table->string('poster_path')->nullable();
            $table->date('release_date')->nullable();
            $table->integer('revenue')->nullable();
            $table->integer('runtime')->nullable();
            $table->integer('state')->nullable();
            $table->string('tagline')->nullable();
            $table->float('vote_average')->nullable();
            $table->integer('vote_count')->nullable();
            $table->string('image')->nullable();
            $table->string('url_dwl')->nullable();
            $table->string('url_origin')->nullable();
            $table->string('extid')->nullable();
            $table->string('id_upload')->nullable();

            $table->timestamps();

            //RELACIONES

            // $table->foreign('director_id')->references('id')->on('directors')
            //     ->inDelete('cascade')
            //     ->onUpdate('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
