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
        Schema::table('schedule_booking', function (Blueprint $table) {
            $table->uuid('batch_id')->nullable()->index()->after('id');
        });
    }

    public function down()
    {
        Schema::table('schedule_booking', function (Blueprint $table) {
            $table->dropColumn('batch_id');
        });
    }

};
