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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('no_room'); // Primary key
            $table->string('name');
            $table->integer('capacity');
            $table->string('status');
            $table->unsignedBigInteger('furniture')->index(); // Foreign key to furniture
            $table->unsignedBigInteger('electronicEquipment')->index(); // Foreign key to electronic_equipment
    
            // Set up foreign key relationships
            
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
