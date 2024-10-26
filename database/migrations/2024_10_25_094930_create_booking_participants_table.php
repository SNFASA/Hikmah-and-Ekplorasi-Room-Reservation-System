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
        Schema::create('booking_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id'); // Foreign key to room_bookings
            $table->unsignedBigInteger('participant_id'); // ID of student or staff
            $table->string('participant_type'); // Either 'student' or 'staff'
    
            $table->string('no_matriks_staff'); // Matriks ID or Staff ID
            $table->string('name');
            $table->string('phone_number');
            $table->unsignedBigInteger('facultyOffice')->index(); // Reference to faculty_office
    
            // Foreign key relationship
            
    
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_participants');
    }
};
