<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailPasswordNotificationsToStudentAndStaffTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Modify the student table
        Schema::table('students', function (Blueprint $table) {
            $table->string('email')->unique()->after('name'); // Adjust 'after' as necessary
            $table->string('password')->after('email');
            $table->boolean('receive_notifications')->default(true)->after('password');
        });

        // Modify the staff table
        Schema::table('staff', function (Blueprint $table) {
            $table->string('email')->unique()->after('name'); // Adjust 'after' as necessary
            $table->string('password')->after('email');
            $table->boolean('receive_notifications')->default(true)->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rollback changes
    }
}
