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
        Schema::create('students', function (Blueprint $table) {
            $table->id('no_matriks'); // Primary key
            $table->string('name');
            $table->unsignedBigInteger('facultyOffice')->index(); // Foreign key to faculty_offices
            $table->unsignedBigInteger('course')->index(); // Foreign key to courses
    
            // Set up foreign key relationships
           
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
