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
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
    
                // Columns to identify as student or staff
                $table->enum('user_type', ['student', 'staff'])->index();
                $table->unsignedBigInteger('facultyOffice')->nullable()->index();
                $table->unsignedBigInteger('course')->nullable()->index();
                $table->string('role')->nullable();
    
                // Foreign keys for related tables
               
            });
        }
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
