<?php

namespace App\Http\Controllers;

use App\Models\room;
use App\Models\furniture;
use App\Models\electronic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->isAdmin()) {
                abort(403, 'Unauthorized access. Admins only.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $rooms = Room::orderBy('no_room', 'ASC')->paginate(10);
        return view('backend.room.index')->with('rooms', $rooms);
    }

    public function create()
    {
        $type_rooms = ['HIKMAH', 'EKSPLORASI'];
        $furnitures = furniture::all();
        $electronics = electronic::all();
        return view('backend.room.create', compact('type_rooms', 'furnitures', 'electronics'));
    }
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
            'furniture' => 'nullable|array',
            'electronicEquipment' => 'nullable|array',
            'type_room' => 'required|string|in:HIKMAH,EKSPLORASI',
            'status' => 'required|string|in:valid,invalid',
        ]);
    
        DB::transaction(function () use ($request) {
            try {
                // Create the room
                $room = new Room();
                $room->name = $request->name;
                $room->capacity = $request->capacity;
                $room->type_room = $request->type_room;
                $room->status = $request->status;
                $room->save();
        
                // Log the saved room and check the ID
                \Log::info('Room after save:', $room->toArray());
        
                // If no room ID is generated, throw an exception
                if (!$room->no_room) {
                    throw new \Exception('Room ID not generated!');
                }
        
                // Attach furniture if available
                if (!empty($request->furniture)) {
                    \Log::info('Attaching furniture:', $request->furniture);
                    $room->furnitures()->attach($request->furniture);
                }
        
                // Attach electronic equipment if available
                if (!empty($request->electronicEquipment)) {
                    \Log::info('Attaching electronics:', $request->electronicEquipment);
                    $room->electronics()->attach($request->electronicEquipment);
                }
            } catch (\Exception $e) {
                \Log::error('Error saving room:', ['error' => $e->getMessage()]);
                throw $e;  // Rethrow the exception
            }
        });
        
    
        return redirect()->route('room.index')->with('success', 'Room created successfully!');
    }
    
    public function edit($id)
    {
        $type_rooms = ['HIKMAH', 'EKSPLORASI'];
        $room = room::findOrFail($id);
        $furnitures = furniture::all();
        $electronics = electronic::all();

        return view('backend.room.edit', compact('room', 'type_rooms', 'furnitures', 'electronics'));
    }

    public function update(Request $request, $id)
    {
        $room = room::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'type_room' => 'required|string|max:255|in:HIKMAH,EKSPLORASI',
            'furniture' => 'required|array',
            'furniture.*' => 'exists:furniture,no_furniture',
            'electronicEquipment' => 'required|array',
            'electronicEquipment.*' => 'exists:electronic_equipment,no_electronicEquipment',
        ]);

        // Update room details
        $room->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'status' => $request->status,
            'type_room' => $request->type_room,
        ]);

        // Sync furniture and electronic equipment
        $room->furniture()->sync($request->furniture);
        $room->electronicEquipment()->sync($request->electronic_equipment);

        return redirect()->route('backend.room.index')->with('success', 'Room updated successfully.');
    }

    public function destroy($id)
    {
        $room = room::findOrFail($id);

        // Detach related furniture and electronics
        $room->furniture()->detach();
        $room->electronicEquipment()->detach();

        $room->delete();

        return redirect()->route('backend.room.index')->with('success', 'Room deleted successfully.');
    }
}
