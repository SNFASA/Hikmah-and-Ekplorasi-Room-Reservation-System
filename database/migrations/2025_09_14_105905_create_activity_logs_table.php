<?php
// database/migrations/create_activity_logs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('activity_type'); // booking, reservation, room, equipment, maintenance, etc.
            $table->string('action'); // created, updated, deleted, approved, rejected, etc.
            $table->text('description');
            $table->string('model_type')->nullable(); // App\Models\Booking, App\Models\FasilitesReservation, etc.
            $table->unsignedBigInteger('model_id')->nullable(); // ID of the affected record
            $table->unsignedBigInteger('user_id')->nullable(); // Who performed the action
            $table->string('user_name')->nullable(); // Cache user name
            $table->string('ip_address')->nullable();
            $table->json('old_values')->nullable(); // Previous values for updates
            $table->json('new_values')->nullable(); // New values for updates
            $table->enum('status', ['completed', 'pending', 'failed', 'cancelled'])->default('completed');
            $table->string('severity', 20)->default('info'); // info, warning, error, success
            $table->timestamps();
            
            $table->index(['activity_type', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['model_type', 'model_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};