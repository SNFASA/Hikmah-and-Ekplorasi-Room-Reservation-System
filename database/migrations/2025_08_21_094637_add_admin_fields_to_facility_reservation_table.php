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
        Schema::table('facility_reservation', function (Blueprint $table) {
            $table->text('admin_comment')->nullable()->after('status');
            $table->unsignedBigInteger('admin_updated_by')->nullable()->after('admin_comment');
            $table->timestamp('admin_updated_at')->nullable()->after('admin_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facility_reservation', function (Blueprint $table) {
            //
        });
    }
};
