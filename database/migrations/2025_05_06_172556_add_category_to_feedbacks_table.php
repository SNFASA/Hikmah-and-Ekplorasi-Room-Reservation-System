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
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->string('category')->default('general')->after('comment');
            // 'general' is the default category
            // 'damage' is the category for feedback with keywords or low rating
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
