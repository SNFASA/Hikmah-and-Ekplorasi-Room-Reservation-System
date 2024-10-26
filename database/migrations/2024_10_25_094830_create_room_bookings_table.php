<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('room_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id'); // Foreign key to rooms
            $table->enum('room_type', ['hikmah', 'explorasi']); // Room type
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Booking status
            $table->text('purpose_of_usage'); // Purpose of booking
            $table->date('date'); // Booking date
    
            // Set up foreign key relationship to rooms
            
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_bookings');
    }
};
