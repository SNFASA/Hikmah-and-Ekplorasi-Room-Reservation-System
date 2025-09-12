<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasilitesReservation extends Model
{
    use HasFactory;

    protected $table = 'facility_reservation';

    protected $fillable = [
        'created_by_matric_no',
        'email',
        'name',
        'staff_id_matric_no',
        'faculty_office_id',
        'contact_no',
        'room_id',
        'other_room_description',
        'purpose_program_name',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'no_of_participants',
        'participant_category',
        'other_participant_category',
        'event_type',
        'file_path',
        'file_original_name',
        'file_size',
        'file_type',
        'declaration_accepted',
        'status',
        'admin_comment',
        'admin_updated_by',
        'admin_updated_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        // Remove the problematic time casts - let them remain as strings
        'declaration_accepted' => 'boolean',
        'admin_updated_at' => 'datetime',
    ];

    // Relationships
    public function createdBy()
    {
        return $this->belongsTo(List_Student_Booking::class, 'created_by_matric_no', 'id');
    }
    
    public function listStudentBooking()
    {
        return $this->belongsTo(List_Student_Booking::class, 'staff_id_matric_no', 'id');
    }

    public function facultyOffice()
    {
        return $this->belongsTo(faculty_offices::class, 'faculty_office_id', 'no_facultyOffice');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'no_room');
    }

    public function adminUpdatedBy()
    {
        return $this->belongsTo(User::class, 'admin_updated_by', 'id');
    }

    // Status helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    // Status badge for display
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="badge badge-warning">⏳ Pending</span>',
            'approved' => '<span class="badge badge-success">✅ Approved</span>',
            'rejected' => '<span class="badge badge-danger">❌ Rejected</span>',
            'cancelled' => '<span class="badge badge-secondary">⚠️ Cancelled</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-light">Unknown</span>';
    }

    // Fixed duration calculation
    public function getDurationHoursAttribute()
    {
        try {
            // Parse date and time separately, then combine
            $startDate = \Carbon\Carbon::parse($this->start_date);
            $endDate = \Carbon\Carbon::parse($this->end_date);
            
            // Parse just the time part (H:i format)
            $startTime = \Carbon\Carbon::createFromFormat('H:i:s', $this->start_time);
            $endTime = \Carbon\Carbon::createFromFormat('H:i:s', $this->end_time);
            
            // Combine date and time
            $start = $startDate->setTimeFrom($startTime);
            $end = $endDate->setTimeFrom($endTime);
            
            return $start->diffInHours($end);
        } catch (\Exception $e) {
            // Fallback: try alternative parsing
            try {
                $start = \Carbon\Carbon::parse($this->start_date . ' ' . $this->start_time);
                $end = \Carbon\Carbon::parse($this->end_date . ' ' . $this->end_time);
                return $start->diffInHours($end);
            } catch (\Exception $e2) {
                \Log::error('Failed to calculate duration for reservation ' . $this->id . ': ' . $e2->getMessage());
                return 0; // Default fallback
            }
        }
    }

    // Scope for filtering by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope for recent reservations
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}