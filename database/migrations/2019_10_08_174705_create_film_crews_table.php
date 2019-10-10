<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmCrewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_crews', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('film_id')->unsigned();
            $table->bigInteger('contributor_id')->unsigned();

            $table->string('tmdb_credit_id');
            $table->string('department');
            $table->string('job');
            $table->string('order');
            
            $table->timestamps();

            $table
                ->foreign('film_id')
                ->references('id')
                ->on('films')
                ->onDelete('cascade');

            $table
                ->foreign('contributor_id')
                ->references('id')
                ->on('contributors')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('film_crews');
    }
}
