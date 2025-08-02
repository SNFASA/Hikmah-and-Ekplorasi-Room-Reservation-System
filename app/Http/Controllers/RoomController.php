<?php

namespace App\Http\Controllers;

use App\Models\room;
use App\Models\furniture;
use App\Models\electronic;
use App\Models\TypeRooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * RoomController constructor.
     *
     * This constructor applies a middleware to all methods in the RoomController.
     * The middleware checks if the authenticated user is an admin.
     * If the user is not authenticated or not an admin, a 403 Unauthorized access error is returned.
     *
     * @return void
     */
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

    /**
     * Displays the room creation form.
     * This method retrieves all available furniture and electronics from the database,
     * and renders the room creation form with the retrieved data.
     * @return \Illuminate\View\View The room creation form view with furniture and electronics data.
     */
    public function create()
    {
        $type_rooms = TypeRooms::orderby('name')->get(); 
        $furnitures = furniture::all();
        $electronics = electronic::all();
        return view('backend.room.create', compact('type_rooms', 'furnitures', 'electronics'));
    }
    /**
     * Creates a new room.
     * This method validates the incoming request,
     * creates a new room with the validated data,
     * and attaches the specified furniture and electronic equipment to the room.
     * @param Request $request The incoming request object.
     * @return \Illuminate\Http\RedirectResponse Redirects to the room index page with a success message.
     * @throws \Exception If the room cannot be saved.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
            'furniture' => 'nullable|array',
            'electronicEquipment' => 'nullable|array',
            'type_room' => 'required|exists:type_rooms,id',
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
        $room = room::with(['furnitures', 'electronics'])->findOrFail($id);
        $furnitures = furniture::all();
        $electronics = electronic::all();
        $type_rooms = TypeRooms::orderby('name')->get(); 
        $selectedFurnitures = $room->furnitures;
        $selectedElectronics = $room->electronics;
    
        return view('backend.room.edit', compact('room', 'furnitures', 'electronics','type_rooms', 'selectedFurnitures', 'selectedElectronics'));
    }
    

    public function update(Request $request, $id)
    {
        $room = room::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
            'furniture' => 'nullable|array',
            'electronicEquipment' => 'nullable|array',
            'type_room' => 'required|exists:type_rooms,id',
            'status' => 'required|string|in:valid,invalid',
        ]);

        // Update room details
            DB::transaction(function () use ($request, $id) {
            try {
                
                $room = Room::findOrFail($id);
        
                // Update the room details
                $room->name = $request->name;
                $room->capacity = $request->capacity;
                $room->type_room = $request->type_room;
                $room->status = $request->status;
                $room->save();
        
                // Log the updated room to check the changes
                \Log::info('Room after update:', $room->toArray());
        
                // If no room ID is generated, throw an exception (this is unlikely for an update but kept for safety)
                if (!$room->no_room) {
                    throw new \Exception('Room ID not generated!');
                }
        
                // Update the furniture if available
                if (!empty($request->furniture)) {
                    \Log::info('Attaching furniture:', $request->furniture);
                    // Detach existing furniture before attaching new ones to avoid duplicates
                    $room->furnitures()->sync($request->furniture);  // `sync` will update the relationship
                }
        
                // Update the electronic equipment if available
                if (!empty($request->electronicEquipment)) {
                    \Log::info('Attaching electronics:', $request->electronicEquipment);
                    // Detach existing electronics before attaching new ones
                    $room->electronics()->sync($request->electronicEquipment);  // `sync` will update the relationship
                }
            } catch (\Exception $e) {
                \Log::error('Error updating room:', ['error' => $e->getMessage()]);
                throw $e;  // Rethrow the exception
            }
        });
        

        return redirect()->route('backend.room.index')->with('success', 'Room updated successfully.');
    }

/**
 * Deletes the specified room and its associated furniture and electronics.
 *
 * This method removes the room with the given ID from the database. 
 * Before deletion, it detaches any related furniture and electronics to ensure
 * the integrity of the data. Upon successful deletion, it redirects to the room
 * index page with a success message.
 *
 * @param int $id The ID of the room to be deleted.
 * @return \Illuminate\Http\RedirectResponse Redirects to the room index page with a success message.
 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the room is not found.
 */

    public function destroy($id)
    {
        $room = room::findOrFail($id);

        // Detach related furniture and electronics
        $room->furnitures()->detach();
        $room->electronics()->detach();

        $room->delete();

        return redirect()->route('backend.room.index')->with('success', 'Room deleted successfully.');
    }
    
}
