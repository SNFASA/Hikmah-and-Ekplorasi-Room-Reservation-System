<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop the old 'booking_time' column
            $table->dropColumn('booking_time');

            // Add new columns for time and duration
            $table->time('booking_time_start')->nullable();
            $table->time('booking_time_end')->nullable();
            $table->integer('duration')->nullable()->comment('Duration in minutes'); // Duration in minutes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Add the dropped 'booking_time' column back
            $table->time('booking_time')->nullable();

            // Drop the newly added columns
            $table->dropColumn('booking_time_start');
            $table->dropColumn('booking_time_end');
            $table->dropColumn('duration');
        });
    }
};
