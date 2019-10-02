<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmCastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('film_casts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('film_id');
            
            $table->string('tmdb_credit_id');
            $table->string('tmdb_cast_id');
            $table->string('tmdb_id');
            $table->string('character');
            $table->string('name');
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
        Schema::dropIfExists('film_casts');
    }
}
