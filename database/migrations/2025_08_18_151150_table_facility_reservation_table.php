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
        Schema::create('facility_reservation', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Foreign Keys & Relations
            $table->unsignedBigInteger('created_by_matric_no');
            $table->string('email', 255);
            $table->string('name', 255);
            $table->unsignedBigInteger('staff_id_matric_no');
            $table->unsignedBigInteger('faculty_office_id');
            $table->string('contact_no', 15);
            $table->unsignedBigInteger('room_id')->nullable();

            // Other Details
            $table->string('other_room_description', 500)->nullable();
            $table->text('purpose_program_name');
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');
            $table->integer('no_of_participants');

            $table->enum('participant_category', ['Staff','VVIP','Public','Student','Other']);
            $table->string('other_participant_category', 255)->nullable();
            $table->enum('event_type', ['Physical','Online']);

            // File Uploads
            $table->string('file_path', 500)->nullable();
            $table->string('file_original_name', 255)->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->string('file_type', 100)->nullable();

            // Status / Declaration
            $table->boolean('declaration_accepted')->default(false);
            $table->enum('status', ['pending','approved','rejected','cancelled'])->default('pending');

            $table->timestamps();

            // Indexes
            $table->index(
                ['created_by_matric_no', 'staff_id_matric_no', 'faculty_office_id', 'room_id'],
                'Index_2'
            );
            $table->index('staff_id_matric_no', 'FK_facility_reservation_list_student_booking_2');
            $table->index('faculty_office_id', 'FK_facility_reservation_faculty_offices');
            $table->index('room_id', 'FK_facility_reservation_rooms');

            // Foreign Keys
            $table->foreign('faculty_office_id', 'FK_facility_reservation_faculty_offices')
                ->references('no_facultyOffice')
                ->on('faculty_offices')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('created_by_matric_no', 'FK_facility_reservation_list_student_booking')
                ->references('id')
                ->on('list_student_booking')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('staff_id_matric_no', 'FK_facility_reservation_list_student_booking_2')
                ->references('id')
                ->on('list_student_booking')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('room_id', 'FK_facility_reservation_rooms')
                ->references('no_room')
                ->on('rooms')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_reservation');
    }
};
