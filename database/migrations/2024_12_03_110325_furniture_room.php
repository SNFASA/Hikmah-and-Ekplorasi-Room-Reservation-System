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
        Schema::create('furniture_room', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->bigInteger('room_id')->unsigned(); // Foreign key to rooms table
            $table->bigInteger('furniture_id')->unsigned(); // Foreign key to furniture table
            //$table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade'); // Foreign key constraint
            //$table->foreign('furniture_id')->references('id')->on('furniture')->onDelete('cascade'); // Foreign key constraint
            $table->timestamps(); // For tracking creation and update times
        });
        
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
