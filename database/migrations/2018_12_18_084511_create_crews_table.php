<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('crew_tmdb_id')->nullable();
            $table->string('departament')->nullable();
            $table->string('job')->nullable();
            $table->string('name')->nullable();
            $table->string('profile_path')->nullable();

            $table->integer('movie_id')->unsigned();
            
            $table->timestamps();


            //Relaciones    
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
        Schema::dropIfExists('crews');
    }
}
