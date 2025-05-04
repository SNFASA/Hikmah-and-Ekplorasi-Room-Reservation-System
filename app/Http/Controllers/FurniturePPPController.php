<?php

namespace App\Http\Controllers;
use App\Models\furniture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FurniturePPPController extends Controller
{


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || (!auth()->user()->isPpp())) {
                 abort(403, 'Unauthorized access. Admins and PPP users only.');
            }
            return $next($request);
        });
    }


    public function index()
    {
        $furniture = furniture::orderBy('no_furniture', 'ASC')->paginate(10);
        return view('ppp.furniture.index')->with('furniture', $furniture);
    }
    

    public function create()
    {
        $categories = [
            'Desk',
            'Chair',
            'Japaness Table',
            'Whiteboard'
        ];
        return view('ppp.furniture.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:Desk,Chair,Japaness Table,Whiteboard',
            'status' => 'required|string|max:255',
        ]);
        
        furniture::create([  
            'name' => $request->name,
            'category' => $request->category,
            'status' => $request->status,
        ]);
    
        return redirect()->route('ppp.furniture.index')->with('success', 'Furniture created successfully.');
    }
    

    // Show the form for editing the specified 
    public function edit($id)
    {
        $categories = [
            'Desk',
            'Chair',
            'Japaness Table',
            'Whiteboard'
        ];
        $furniture = furniture::findOrFail($id);
        return view('ppp.furniture.edit', compact('furniture', 'categories'));
    }

    // Update the specified electronics in storage
    public function update(Request $request, $id)
    {
        $furniture = furniture::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:Desk,Chair,Japaness Table,Whiteboard', // Adjust according to your categories
            'status' => 'required|string|max:255',
        ]);
        

        $furniture->update([
            'name' => $request->name,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        return redirect()->route('ppp.furniture.index')->with('success', 'furniture updated successfully.');
    }

    // Remove the specified from storage
    public function destroy($id)
    {
        $furniture = furniture::findOrFail($id);
        $furniture->delete();

        return redirect()->route('ppp.furniture.index')->with('success', 'furniture deleted successfully.');
    }

    public function calendar()
    {
        // Fetch bookings
        $bookings = DB::table('bookings')
        ->join('rooms', 'bookings.no_room', '=', 'rooms.no_room')
        ->select(
            'booking_date as start',
            DB::raw("CONCAT(booking_date, ' ', booking_time_end) as end"),
            DB::raw("CONCAT('Booked: ', rooms.name) as title"),
            DB::raw("'#28a745' as color") // Green for booked events
        )
        ->get();

    $invalidSchedules = DB::table('schedule_booking')
        ->join('rooms', 'schedule_booking.roomid', '=', 'rooms.no_room')
        ->select(
            'invalid_date as start',
            DB::raw("CONCAT(invalid_date, ' ', invalid_time_end) as end"),
            DB::raw("CONCAT('Invalid: ', rooms.name) as title"),
            DB::raw("'#dc3545' as color") // Red for invalid events
        )
        ->get();

    // Merge events
    $events = $bookings->merge($invalidSchedules);
    
        return view('frontend.pages.calendarBooking', ['events' => $events]);
    }
}
