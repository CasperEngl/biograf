<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('reserver_id');
            $table->string('reserver_email');
            $table->bigInteger('showing_id')->unsigned();
            $table->string('payment_key')->nullable();
            $table->json('ticket_count');
            $table->dateTime('end');
            $table->boolean('is_guest');

            $table->softDeletes();
            $table->timestamps();

            $table
                ->foreign('showing_id')
                ->references('id')
                ->on('showings')
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
        Schema::dropIfExists('reservations');
    }
}
