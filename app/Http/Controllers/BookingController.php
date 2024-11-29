<?php

namespace App\Http\Controllers;

use App\Models\bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Constructor with middleware to restrict access to admins
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized access. Admins only.');
            }
            return $next($request);
        });
    }

    // Display a listing of all bookingsup
    public function index()
    {
        $bookings = bookings::paginate(10); 
        return view('backend.booking.index', compact('bookings'));
    }

    // Show the form for creating a new booking
    public function create()
    {
        return view('backend.booking.create');
    }

    // Store a newly created booking in storage
    public function store(Request $request)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'booking_time' => 'required|date_format:H:i',
            'purpose' => 'required|string|max:255',
            'no_room' => 'required|exists:rooms,no_room',
            'phone_number' => 'required|string|max:15',
            'list_student' => 'nullable|exists:list_student_booking,id',
        ]);

        $booking = bookings::create([
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'purpose' => $request->purpose,
            'no_room' => $request->no_room,
            'phone_number' => $request->phone_number,
            'list_student' => $request->list_student,
            'status' => 'pending',
        ]);

        return redirect()->route('backend.booking.index')->with('success', 'Booking created successfully.');
    }

    // Show the form for editing the specified booking
    public function edit($id)
    {
        $booking = bookings::findOrFail($id);
        return view('backend.booking.edit', compact('booking'));
    }

    // Update the specified booking in storage
    public function update(Request $request, $id)
    {
        $booking = bookings::findOrFail($id);

        $request->validate([
            'booking_date' => 'required|date',
            'booking_time' => 'required|date_format:H:i',
            'purpose' => 'required|string|max:255',
            'no_room' => 'required|exists:rooms,no_room',
            'phone_number' => 'required|string|max:15',
            'list_student' => 'nullable|exists:list_student_booking,id',
        ]);

        $booking->update([
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'purpose' => $request->purpose,
            'no_room' => $request->no_room,
            'phone_number' => $request->phone_number,
            'list_student' => $request->list_student,
            'status' => 'pending',
        ]);

        return redirect()->route('backend.booking.index')->with('success', 'Booking updated successfully.');
    }

    // Remove the specified booking from storage
    public function destroy($id)
    {
        $booking = bookings::findOrFail($id);
        $booking->delete();

        return redirect()->route('backend.booking.index')->with('success', 'Booking deleted successfully.');
    }

    // Generate booking chart data for bookings
    public function roomChart()
    {
        $year = Carbon::now()->year;

        $items = bookings::whereYear('created_at', $year)
            ->where('status', 'approved')
            ->get()
            ->groupBy(function ($d) {
                return Carbon::parse($d->created_at)->format('m');
            });

        $result = [];
        foreach ($items as $month => $bookingCollections) {
            $amount = $bookingCollections->sum('amount');
            $m = intval($month);
            $result[$m] = $amount;
        }

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = !empty($result[$i]) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }

        return $data;
    }
}
