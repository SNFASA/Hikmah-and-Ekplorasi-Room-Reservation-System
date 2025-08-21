<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FasilitesReservation;
use App\Models\User;
use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Allow access if the user is either an admin, a user, or a PPP
            if (!auth()->user() ||
                (!auth()->user()->isAdmin() && !auth()->user()->isUser() && !auth()->user()->isPpp())) {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of reservations
     */
    public function index(Request $request)
    {
        $query = FasilitesReservation::with(['createdBy', 'staffMember', 'room', 'facultyOffice']);

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range if provided
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('purpose_program_name', 'like', "%{$search}%");
            });
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get status counts for dashboard
        $statusCounts = [
            'pending' => FasilitesReservation::where('status', 'pending')->count(),
            'approved' => FasilitesReservation::where('status', 'approved')->count(),
            'rejected' => FasilitesReservation::where('status', 'rejected')->count(),
            'cancelled' => FasilitesReservation::where('status', 'cancelled')->count(),
        ];

        return view('admin.reservations.index', compact('reservations', 'statusCounts'));
    }

    /**
     * Display the specified reservation
     */
    public function show($id)
    {
        $reservation = FasilitesReservation::with([
            'createdBy',
            'staffMember',
            'room',
            'facultyOffice',
            'adminUpdatedBy'
        ])->findOrFail($id);

        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Update reservation status and send notification email
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,cancelled',
            'admin_comment' => 'nullable|string|max:1000',
        ]);

        $reservation = FasilitesReservation::findOrFail($id);
        
        // Store old status for comparison
        $oldStatus = $reservation->status;
        
        // Update reservation with new status and admin info
        $reservation->update([
            'status' => $request->status,
            'admin_comment' => $request->admin_comment,
            'admin_updated_by' => Auth::id(),
            'admin_updated_at' => now(),
        ]);

        try {
            // Send status update email only if status actually changed
            if ($oldStatus !== $request->status) {
                $emailController = new EmailController();
                $emailController->sendReservationStatusUpdateEmail($reservation->id);
                
                Log::info("Reservation status updated and email sent", [
                    'reservation_id' => $reservation->id,
                    'old_status' => $oldStatus,
                    'new_status' => $request->status,
                    'updated_by' => Auth::id(),
                    'admin_comment' => $request->admin_comment
                ]);

                $message = "Reservation status updated successfully from '{$oldStatus}' to '{$request->status}' and notification email sent to all involved parties.";
            } else {
                $message = "Reservation details updated successfully. No status change detected, so no email was sent.";
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            Log::error("Failed to send reservation status update email", [
                'reservation_id' => $reservation->id,
                'error' => $e->getMessage(),
                'updated_by' => Auth::id()
            ]);

            // Status was updated but email failed
            return redirect()->back()
                ->with('warning', 'Reservation status updated successfully, but there was an issue sending the notification email. Please check the email configuration.');
        }
    }

    /**
     * Bulk update multiple reservations status
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'reservation_ids' => 'required|array',
            'reservation_ids.*' => 'exists:facility_reservation,id',
            'status' => 'required|in:pending,approved,rejected,cancelled',
            'admin_comment' => 'nullable|string|max:1000',
        ]);

        $reservationIds = $request->reservation_ids;
        $updatedCount = 0;
        $emailsSent = 0;
        $emailErrors = 0;

        foreach ($reservationIds as $id) {
            $reservation = FasilitesReservation::findOrFail($id);
            $oldStatus = $reservation->status;

            // Update status
            $reservation->update([
                'status' => $request->status,
                'admin_comment' => $request->admin_comment,
                'admin_updated_by' => Auth::id(),
                'admin_updated_at' => now(),
            ]);

            $updatedCount++;

            // Send email if status changed
            if ($oldStatus !== $request->status) {
                try {
                    $emailController = new EmailController();
                    $emailController->sendReservationStatusUpdateEmail($id);
                    $emailsSent++;
                } catch (\Exception $e) {
                    $emailErrors++;
                    Log::error("Failed to send bulk status update email", [
                        'reservation_id' => $id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $message = "Successfully updated {$updatedCount} reservation(s).";
        if ($emailsSent > 0) {
            $message .= " Sent {$emailsSent} notification email(s).";
        }
        if ($emailErrors > 0) {
            $message .= " {$emailErrors} email(s) failed to send.";
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Export reservations to CSV
     */
    public function export(Request $request)
    {
        $query = FasilitesReservation::with(['createdBy', 'staffMember', 'room']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $reservations = $query->orderBy('created_at', 'desc')->get();

        $filename = 'facility_reservations_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($reservations) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'ID', 'Name', 'Email', 'Purpose', 'Room', 'Start Date', 'Start Time',
                'End Date', 'End Time', 'Participants', 'Status', 'Admin Comment',
                'Created At', 'Updated At'
            ]);

            // CSV data
            foreach ($reservations as $reservation) {
                fputcsv($file, [
                    $reservation->id,
                    $reservation->name,
                    $reservation->email,
                    $reservation->purpose_program_name,
                    $reservation->room->name ?? 'N/A',
                    $reservation->start_date,
                    $reservation->start_time,
                    $reservation->end_date,
                    $reservation->end_time,
                    $reservation->no_of_participants,
                    $reservation->status,
                    $reservation->admin_comment ?? '',
                    $reservation->created_at,
                    $reservation->updated_at,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}