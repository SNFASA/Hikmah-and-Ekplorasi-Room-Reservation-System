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
        Schema::create('schedule_booking', function (Blueprint $table) {
            $table->id();
            $table->date('invalid_date');
            $table->time('invalid_time_start');
            $table->time('invalid_time_end');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_booking');
    }
};
