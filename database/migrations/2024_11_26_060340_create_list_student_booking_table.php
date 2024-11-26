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
            $table->string('user_no_matriks1');
            $table->string('user_no_matriks2');
            $table->string('user_no_matriks3');
            $table->string('user_no_matriks4');
            $table->string('user_no_matriks5');
            $table->string('user_no_matriks6');
            $table->string('user_no_matriks7');
            $table->string('user_no_matriks8');
            $table->string('user_no_matriks9');
            $table->string('user_no_matriks10');
            $table->foreign('user_no_matriks1')->references('no_matriks')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_no_matriks2')->references('no_matriks')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_no_matriks3')->references('no_matriks')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_no_matriks4')->references('no_matriks')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_no_matriks5')->references('no_matriks')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_no_matriks6')->references('no_matriks')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_no_matriks7')->references('no_matriks')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_no_matriks8')->references('no_matriks')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_no_matriks9')->references('no_matriks')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_no_matriks10')->references('no_matriks')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
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
