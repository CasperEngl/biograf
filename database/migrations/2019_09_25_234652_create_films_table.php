<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('tmdb_id');
            $table->string('imdb_id')->nullable();
            $table->string('slug');
            $table->string('category');
            $table->string('language');
            $table->json('colors')->nullable();
            $table->json('homepage')->nullable();
            $table->json('title');
            $table->json('overview');

            $table->softDeletes();
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
        Schema::dropIfExists('films');
    }
}
