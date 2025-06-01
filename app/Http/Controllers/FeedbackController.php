<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\bookings;
use App\Models\maintenance;
use Illuminate\Http\Request;
use App\Models\room;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    // Senarai semua maklum balas
    public function index()
    {
        $feedbacks = Feedback::with('booking', 'user')->latest()->paginate(10);
        return view('backend.feedback.index', compact('feedbacks'));
    }

    // Papar borang untuk maklum balas baru
    public function create(Request $request)
    {
        $bookingId = $request->booking_id;
        $booking = bookings::with('room.furnitures', 'room.electronics')->findOrFail($bookingId);
    
        // Semak jika user sudah beri feedback
        $feedback = Feedback::where('booking_id', $bookingId)->first();
    
        return view('frontend.pages.feedbackcreate', compact('booking', 'feedback'));
    }
    

    // Simpan maklum balas baru
    public function store(Request $request)
    {
        try {
            // Clean up empty elements
            $request->merge([
                'damaged_furnitures' => array_filter((array) $request->input('damaged_furnitures')),
                'damaged_electronics' => array_filter((array) $request->input('damaged_electronics')),
            ]);
    
            $request->validate([
                'booking_id' => 'required|exists:bookings,id',
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string',
                'damaged_furnitures' => 'array',
                'damaged_furnitures.*' => 'integer|exists:furniture,no_furniture',
                'damaged_electronics' => 'array',
                'damaged_electronics.*' => 'integer|exists:electronic_equipment,no_electronicEquipment',
            ]);
    
            \Log::info('Feedback validation passed', $request->all());
    
            $user = Auth::user();
            $category = 'general';
    
            $keywords = ['rosak', 'kerosakan', 'pecah', 'tak berfungsi', 'broken', 'not working'];
            foreach ($keywords as $word) {
                if (stripos($request->comment, $word) !== false || $request->rating <= 2) {
                    $category = 'damage';
                    break;
                }
            }
    
            $feedback = Feedback::create([
                'booking_id' => $request->booking_id,
                'user_id' => $user->id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'category' => $category,
            ]);
    
            \Log::info('Feedback created successfully', ['feedback_id' => $feedback->id]);
    
            if ($category === 'damage') {
                $booking = Bookings::with('room')->find($request->booking_id);
    
                foreach ($request->damaged_furnitures as $furnitureId) {
                    Maintenance::create([
                        'title' => 'Damage Report: Furniture',
                        'description' => $request->comment ?? 'Reported via feedback',
                        'itemType' => 'furniture',
                        'item_id' => $furnitureId,
                        'room_id' => $booking->no_room,
                        'date_maintenance' => now(),
                        'status' => 'pending',
                        'reported_by' => auth()->id(),
                    ]);
                }
    
                foreach ($request->damaged_electronics as $electronicId) {
                    Maintenance::create([
                        'title' => 'Damage Report: Electronic',
                        'description' => $request->comment ?? 'Reported via feedback',
                        'itemType' => 'electronic_equipment',
                        'item_id' => $electronicId,
                        'room_id' => $booking->no_room,
                        'date_maintenance' => now(),
                        'status' => 'pending',
                        'reported_by' => auth()->id(),
                    ]);
                }
    
                if (empty($request->damaged_furnitures) && empty($request->damaged_electronics)) {
                    Maintenance::create([
                        'title' => 'General Room Issue Reported',
                        'description' => $request->comment ?? 'Reported via feedback',
                        'itemType' => 'other',
                        'item_text' => 'Not specified',
                        'room_id' => $booking->no_room,
                        'date_maintenance' => now(),
                        'status' => 'pending',
                        'reported_by' => auth()->id(),
                    ]);
                }
            }
    
            return redirect()->route('my.bookings')->with('success', 'Feedback was successfully sent!');
        } catch (\Exception $e) {
            \Log::error('Feedback error: ' . $e->getMessage());
            \Log::info('Damaged furnitures:', request()->input('damaged_furnitures'));
            \Log::info('Damaged electronics:', request()->input('damaged_electronics'));
            dd($request->input('damaged_furnitures'));
            return back()->with('error', 'There was an error while sending feedback. Please try again.');
        }
    }
    // Papar maklum balas tertentu
    public function show(Feedback $feedback)
    {
        return view('backend.feedback.show', compact('feedback'));
    }

    // Papar borang untuk mengedit maklum balas
    public function edit(Feedback $feedback)
    {
        $this->authorize('update', $feedback);
        $booking = $feedback->booking()->with('room.furnitures', 'room.electronics')->firstOrFail();
        return view('frontend.pages.feedbackedit', compact('feedback', 'booking'));
    }
    

    // Kemas kini maklum balas
    public function update(Request $request, Feedback $feedback)
    {
        $this->authorize('update', $feedback);
    
        try {
            // Bersihkan input
            $request->merge([
                'damaged_furnitures' => array_filter((array) $request->input('damaged_furnitures')),
                'damaged_electronics' => array_filter((array) $request->input('damaged_electronics')),
            ]);
    
            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'nullable|string',
                'damaged_furnitures' => 'array',
                'damaged_furnitures.*' => 'integer|exists:furniture,no_furniture',
                'damaged_electronics' => 'array',
                'damaged_electronics.*' => 'integer|exists:electronic_equipment,no_electronicEquipment',
            ]);
    
            $category = 'general';
            $keywords = ['rosak', 'kerosakan', 'pecah', 'tak berfungsi', 'broken', 'not working'];
            foreach ($keywords as $word) {
                if (stripos($request->comment, $word) !== false || $request->rating <= 2) {
                    $category = 'damage';
                    break;
                }
            }
    
            $feedback->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
                'category' => $category,
            ]);
    
            if ($category === 'damage') {
                $booking = Bookings::with('room')->findOrFail($feedback->booking_id);
    
                // Tambah damage untuk perabot
                foreach ($request->damaged_furnitures as $furnitureId) {
                    maintenance::create([
                        'title' => 'Damage Report: Furniture',
                        'description' => $request->comment ?? 'Reported via feedback',
                        'itemType' => 'furniture',
                        'item_id' => $furnitureId,
                        'room_id' => $booking->no_room,
                        'date_maintenance' => now(),
                        'status' => 'pending',
                        'reported_by' => auth()->id(),
                    ]);
                }
    
                // Tambah damage untuk elektronik
                foreach ($request->damaged_electronics as $electronicId) {
                    maintenance::create([
                        'title' => 'Damage Report: Electronic',
                        'description' => $request->comment ?? 'Reported via feedback',
                        'itemType' => 'electronic_equipment',
                        'item_id' => $electronicId,
                        'room_id' => $booking->no_room,
                        'date_maintenance' => now(),
                        'status' => 'pending',
                        'reported_by' => auth()->id(),
                    ]);
                }
    
                // Jika tiada perabot/elektronik ditanda tetapi komen rosak
                if (empty($request->damaged_furnitures) && empty($request->damaged_electronics)) {
                    maintenance::create([
                        'title' => 'General Room Issue Reported',
                        'description' => $request->comment ?? 'Reported via feedback',
                        'itemType' => 'other',
                        'item_text' => 'Not specified',
                        'room_id' => $booking->no_room,
                        'date_maintenance' => now(),
                        'status' => 'pending',
                        'reported_by' => auth()->id(),
                    ]);
                }
            }
    
            return redirect()->route('my.bookings')->with('success', 'Feedback was successfully update!');
        } catch (\Exception $e) {
            \Log::error('Update feedback error: ' . $e->getMessage());
            return back()->with('error', 'There was an error while updating feedback. Please try again.');
        }
    }
    

    // Hapus maklum balas
    public function destroy(Feedback $feedback)
    {
        $this->authorize('delete', $feedback);
        $feedback->delete();
        return redirect()->route('my.bookings')->with('success', 'Feedback deleted successfully.');
    }
    public function statistic()
    {
        // Get all rooms with related feedback via bookings
        $roomStats = room::with(['bookings.feedback'])->get()->map(function ($room) {
            $allFeedbacks = $room->bookings->pluck('feedback')->filter();
    
            $ratings = $allFeedbacks->pluck('rating');
            $comments = $allFeedbacks->pluck('comment')->filter()->count();
            $categories = $allFeedbacks->pluck('category')->filter();
    
            $ratingBreakdown = $ratings->countBy(); // e.g. [5 => 10, 4 => 3, ...]
            $averageRating = $ratings->avg();
            $mostCommonCategory = $categories->countBy()->sortDesc()->keys()->first();
    
            return [
                'room_no' => $room->no_room,
                'room_name' => $room->name,
                'total_feedbacks' => $ratings->count(),
                'average_rating' => round($averageRating, 2),
                'rating_breakdown' => $ratingBreakdown,
                'comment_count' => $comments,
                'top_category' => $mostCommonCategory ?? 'N/A',
            ];
        });
    
        return view('backend.feedback.statistic', compact('roomStats'));
    }
    
    

}
