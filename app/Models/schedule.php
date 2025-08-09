<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedule_booking';

    protected $fillable = [
        'invalid_date',
        'invalid_time_start',
        'invalid_time_end',
        'roomid',
        'batch_id'
    ];

    // Ensure primary key is set correctly
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    // Cast attributes to proper types
    protected $casts = [
        'invalid_date' => 'date',
        'invalid_time_start' => 'datetime:H:i',
        'invalid_time_end' => 'datetime:H:i',
    ];

    // Add debugging to model events
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            Log::info('Schedule model deleting event - ID: ' . $model->id);
            Log::info('Model attributes: ' . json_encode($model->attributes));
        });

        static::deleted(function ($model) {
            Log::info('Schedule model deleted event - ID: ' . $model->id);
        });
    }

    // Relationship with room
    public function room()
    {
        return $this->belongsTo(\App\Models\Room::class, 'roomid', 'no_room');
    }

    // Scope to get records by batch
    public function scopeByBatch($query, $batchId)
    {
        return $query->where('batch_id', $batchId);
    }

    // Method to force delete using query builder
    public function forceDelete()
    {
        try {
            Log::info("Force deleting schedule ID: {$this->id}");
            return \DB::table($this->table)->where($this->primaryKey, $this->id)->delete();
        } catch (\Exception $e) {
            Log::error("Force delete failed: " . $e->getMessage());
            throw $e;
        }
    }
}