<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_type',
        'action',
        'description',
        'model_type',
        'model_id',
        'user_id',
        'user_name',
        'ip_address',
        'old_values',
        'new_values',
        'status',
        'severity'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeRecent($query, $limit = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }

    // Accessors
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getIconAttribute()
    {
        $icons = [
            'booking' => 'fas fa-book',
            'reservation' => 'fas fa-calendar-check',
            'room' => 'fas fa-door-open',
            'furniture' => 'fas fa-chair',
            'electronics' => 'fas fa-desktop',
            'maintenance' => 'fas fa-tools',
            'feedback' => 'fas fa-comment',
            'user' => 'fas fa-user',
            'faculty' => 'fas fa-building',
            'department' => 'fas fa-sitemap',
            'course' => 'fas fa-graduation-cap',
            'schedule' => 'fas fa-clock'
        ];

        return isset($icons[$this->activity_type]) ? $icons[$this->activity_type] : 'fas fa-info-circle';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'completed' => '<span class="badge badge-success">Completed</span>',
            'approved' => '<span class="badge badge-success">Approved</span>',
            'rejected' => '<span class="badge badge-danger">Rejected</span>',
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'failed' => '<span class="badge badge-danger">Failed</span>',
            'cancelled' => '<span class="badge badge-secondary">Cancelled</span>'
        ];

        return isset($badges[$this->status]) ? $badges[$this->status] : '<span class="badge badge-info">Unknown</span>';
    }

    public function getTypeBadgeAttribute()
    {
        $badges = [
            'booking' => '<span class="badge badge-primary">Booking</span>',
            'reservation' => '<span class="badge badge-info">Reservation</span>',
            'room' => '<span class="badge badge-secondary">Room</span>',
            'furniture' => '<span class="badge badge-success">Furniture</span>',
            'electronics' => '<span class="badge badge-warning">Electronics</span>',
            'maintenance' => '<span class="badge badge-danger">Maintenance</span>',
            'feedback' => '<span class="badge badge-dark">Feedback</span>',
            'user' => '<span class="badge badge-primary">User</span>',
            'faculty' => '<span class="badge badge-info">Faculty</span>',
            'department' => '<span class="badge badge-secondary">Department</span>',
            'course' => '<span class="badge badge-success">Course</span>',
            'schedule' => '<span class="badge badge-warning">Schedule</span>'
        ];

        return isset($badges[$this->activity_type]) ? $badges[$this->activity_type] : '<span class="badge badge-light">Other</span>';
    }
}