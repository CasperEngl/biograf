<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('cinema_id')->unsigned();
            $table->bigInteger('reservation_id')->unsigned()->nullable();
            $table->string('row');
            $table->string('column');
            $table->boolean('disability');

            $table->softDeletes();
            $table->timestamps();

            $table
                ->foreign('cinema_id')
                ->references('id')
                ->on('cinemas')
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
        Schema::dropIfExists('seats');
    }
}
