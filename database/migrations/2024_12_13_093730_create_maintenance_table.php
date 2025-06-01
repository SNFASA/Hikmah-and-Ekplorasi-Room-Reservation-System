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
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->String('title');
            $table->String('description');
            $table->enum('itemType',['furniture,electronic_equipment','other']);
            $table->bigInteger('item_id');
            $table->string('item_text')->nullable();
            $table->bigInteger('room_id');
            $table->date('date_maintenance');
            $table->enum('status',['pending','in_progress','completed'])->default('pending');
            $table->foreignId('reported_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance');
    }
};
