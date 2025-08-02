<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Drop the old string column
            $table->dropColumn('type_room');
        });

        Schema::table('rooms', function (Blueprint $table) {
            // Add new unsignedBigInteger column
            $table->unsignedBigInteger('type_room');

            
            $table->foreign('type_room')
                ->references('id')
                ->on('type_rooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['type_room']);
            $table->dropColumn('type_room');

            // Re-add the old string column if rolling back
            $table->string('type_room');
        });
    }
};
