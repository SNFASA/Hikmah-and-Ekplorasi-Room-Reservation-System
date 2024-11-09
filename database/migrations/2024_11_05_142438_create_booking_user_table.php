<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up()
    {
        Schema::create('booking_user', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id');
            $table->string('user_no_matriks');

            // Define the primary key
            $table->primary(['booking_id', 'user_no_matriks']);

            // Foreign key to bookings table
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade')->onUpdate('cascade');

            // Foreign key to users table using no_matriks as a unique identifier
            $table->foreign('user_no_matriks')->references('no_matriks')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_user');
    }
};
