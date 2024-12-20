<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('booking_date');
            $table->time('booking_time_start');
            $table->time('booking_time_end');
            $table->string('purpose');
            $table->integer('duration');
            $table->unsignedBigInteger('no_room');
            $table->string('phone_number', 15);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            // Foreign key to rooms table
           //$table->foreign('no_room')->references('no_room')->on('rooms')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
