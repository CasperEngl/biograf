<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationToSeatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_to_seat', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('reservation_id')->unsigned();
            $table->bigInteger('seat_id')->unsigned();

            $table
                ->foreign('reservation_id')
                ->references('id')
                ->on('reservations')
                ->onDelete('cascade');
                
            $table
                ->foreign('seat_id')
                ->references('id')
                ->on('seats')
                ->onDelete('cascade');

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
        Schema::dropIfExists('reservation_to_seat');
    }
}
