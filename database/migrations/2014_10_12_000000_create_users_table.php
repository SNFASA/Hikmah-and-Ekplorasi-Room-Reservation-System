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
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('no_matriks')->unique()->nullable();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
    
                // Columns to identify as student or staff
                $table->enum('role', ['student', 'staff','admin'])->index();
                $table->unsignedBigInteger('facultyOffice')->nullable()->index();
                $table->unsignedBigInteger('course')->nullable()->index();
                $table->timestamps();
    
                // Foreign keys for related tables
                //$table->foreign('facultyOffice')->references('no_facultyOffice')->on('faculty_offices')->onDelete('cascade')->onUpdate('cascade');
               // $table->foreign('course')->references('no_course')->on('courses')->onDelete('cascade')->onUpdate('cascade');

            });
        }
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
