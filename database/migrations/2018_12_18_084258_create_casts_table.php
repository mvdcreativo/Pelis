<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cast_tmdb_id')->nullable();
            $table->string('character')->nullable();
            $table->string('name')->nullable();
            $table->string('order')->nullable();
            $table->string('profile_path')->nullable();

            $table->integer('movie_id')->unsigned();

            $table->timestamps();

            //RELACIONES
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
        Schema::dropIfExists('casts');
    }
}
