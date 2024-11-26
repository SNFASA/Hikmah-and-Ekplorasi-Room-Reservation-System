<?php

namespace App\Http\Controllers;

use App\Models\bookings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;


class BookingController extends Controller
{
    // Display a listing of bookings for the authenticated user
    public function index()
    {
        $bookings = bookings::whereHas('users', function ($query) {
            $query->where('user_no_matriks', auth()->user()->no_matriks);
        })->paginate(10);

        return view('user.index', compact('bookings'));
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
        ]);

        $booking = bookings::create([
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'purpose' => $request->purpose,
            'no_room' => $request->no_room,
            'phone_number' => $request->phone_number,
            'status' => 'pending',
        ]);

        $booking->users()->attach(auth()->user()->no_matriks);

        return redirect()->route('backend.booking.index')->with('success', 'Booking created successfully.');
    }

    // Show the form for editing the specified booking
    public function edit($id)
    {
        $booking = bookings::findOrFail($id);

        if (!$booking->users()->where('user_no_matriks', auth()->user()->no_matriks)->exists()) {
            abort(403, 'Unauthorized access to this booking.');
        }

        return view('backend.bookings.edit', compact('booking'));
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
        ]);

        $booking->update([
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'purpose' => $request->purpose,
            'no_room' => $request->no_room,
            'phone_number' => $request->phone_number,
        ]);

        return redirect()->route('backend.booking.index')->with('success', 'Booking updated successfully.');
    }

    // Remove the specified booking from storage
    public function destroy($id)
    {
        $booking = bookings::findOrFail($id);

        if (!$booking->users()->where('user_no_matriks', auth()->user()->no_matriks)->exists()) {
            abort(403, 'Unauthorized access to this booking.');
        }

        $booking->delete();

        return redirect()->route('backend.booking.index')->with('success', 'Booking deleted successfully.');
    }

    // Generate PDF for a specific booking
    public function pdf(Request $request)
    {
        $booking = bookings::with(['users'])->findOrFail($request->id);
        $file_name = $booking->booking_number . '-' . $booking->purpose . '.pdf';

        $pdf = PDF::loadView('booking.pdf', compact('booking'));

        return $pdf->download($file_name);
    }
    // Generate income chart data for bookings
    public function roomChart(Request $request)
    {
        $year = Carbon::now()->year;

        $items = bookings::whereYear('created_at', $year)
            ->where('status', 'completed')
            ->get()
            ->groupBy(function ($d) {
                return Carbon::parse($d->created_at)->format('m');
            });

        $result = [];
        foreach ($items as $month => $bookingCollections) {
            $amount = $bookingCollections->sum('amount'); // Assuming `amount` column for each booking
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
