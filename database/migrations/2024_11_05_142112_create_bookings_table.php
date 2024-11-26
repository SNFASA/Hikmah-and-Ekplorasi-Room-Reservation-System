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
            $table->time('booking_time');
            $table->string('purpose');
            $table->unsignedBigInteger('no_room');
            $table->string('phone_number', 15);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('list_student')->nullable(); // Add the new column
            $table->timestamps();

            // Foreign key to rooms table
           //$table->foreign('no_room')->references('no_room')->on('rooms')->onDelete('restrict')->onUpdate('cascade');

            // Foreign key to list_student_booking table
            //$table->foreign('list_student')->references('id')->on('list_student_booking')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
