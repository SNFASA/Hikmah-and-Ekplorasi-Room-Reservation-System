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
        Schema::create('list_student_booking', function (Blueprint $table) {
            $table->id();
            $table->string('user_no_matriks');
            $table->timestamps();
            $table->foreign('user_no_matriks')->references('no_matriks')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_student_booking');
    }
};
