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

            $table->bigInteger('film_id');
            $table->bigInteger('contributor_id');

            $table->string('tmdb_credit_id');
            $table->string('department');
            $table->string('job');
            $table->string('order');
            
            $table->timestamps();
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
