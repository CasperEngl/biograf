<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('showings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('cinema_id')->unsigned();
            $table->bigInteger('film_id')->unsigned();
            
            $table->string('price');
            $table->string('senior_discount');
            $table->string('version');

            $table->date('date');
            $table->dateTimeTz('start');
            $table->dateTimeTz('end');

            $table->softDeletes();
            $table->timestamps();

            $table
                ->foreign('cinema_id')
                ->references('id')
                ->on('cinemas')
                ->onDelete('cascade');

            $table
                ->foreign('film_id')
                ->references('id')
                ->on('films')
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
        Schema::dropIfExists('showings');
    }
}
