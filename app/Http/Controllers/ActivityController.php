<?php
namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display dashboard with recent activities
     */
    public function dashboardActivities()
    {
        // Get recent activities for dashboard
        $activities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get activity statistics for dashboard cards
        $stats = [
            'today_activities' => ActivityLog::whereDate('created_at', today())->count(),
            'week_activities' => ActivityLog::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'total_activities' => ActivityLog::count(),
            'failed_activities' => ActivityLog::where('status', 'failed')->whereDate('created_at', today())->count()
        ];

        // Get activity breakdown by type
        $activityTypes = ActivityLog::selectRaw('activity_type, COUNT(*) as count')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->groupBy('activity_type')
            ->orderBy('count', 'desc')
            ->get();

        return view('backend.dashboard.index', compact('activities', 'stats', 'activityTypes'));
    }

    /**
     * Get recent activities via API
     */
    public function getRecentActivities(Request $request)
    {
        $limit = $request->get('limit', 10);
        $type = $request->get('type');
        $timeframe = $request->get('timeframe', 'all');

        $query = ActivityLog::with('user')
            ->orderBy('created_at', 'desc');

        // Filter by type if specified
        if ($type) {
            $query->where('activity_type', $type);
        }

        // Filter by timeframe
        switch ($timeframe) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'week':
                $query->whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ]);
                break;
            case 'month':
                $query->whereMonth('created_at', now()->month);
                break;
        }

        $activities = $query->limit($limit)->get();

        return response()->json([
            'success' => true,
            'activities' => $activities->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'description' => $activity->description,
                    'type_badge' => $activity->type_badge,
                    'user_name' => $activity->user_name,
                    'time_ago' => $activity->time_ago,
                    'status_badge' => $activity->status_badge,
                    'icon' => $activity->icon,
                    'created_at' => $activity->created_at->format('Y-m-d H:i:s')
                ];
            })
        ]);
    }

    /**
     * Show full activity log page
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->filled('type')) {
            $query->where('activity_type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->paginate(50);

        // Get filter options
        $types = ActivityLog::distinct()->pluck('activity_type');
        $statuses = ActivityLog::distinct()->pluck('status');

        return view('backend.index', compact('activities', 'types', 'statuses'));
    }
}