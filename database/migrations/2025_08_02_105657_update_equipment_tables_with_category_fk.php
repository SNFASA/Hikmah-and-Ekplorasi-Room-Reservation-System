<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Electronic Equipment Table Update
        Schema::table('electronic_equipment', function (Blueprint $table) {
            // Drop old string category
            $table->dropColumn('category');
        });

        Schema::table('electronic_equipment', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories_equipment')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        // Furniture Table Update
        Schema::table('furniture', function (Blueprint $table) {
            // Drop old string category
            $table->dropColumn('category');
        });

        Schema::table('furniture', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories_equipment')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        // Rollback: drop foreign key and restore old column
        Schema::table('electronic_equipment', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->string('category');
        });

        Schema::table('furniture', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->string('category');
        });
    }
};
