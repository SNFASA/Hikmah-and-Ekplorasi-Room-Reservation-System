<?php

namespace App\Http\Controllers;

use App\Models\room;
use App\Models\furniture;
use App\Models\electronic;
use App\Models\TypeRooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Services\ActivityLogger;

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
     * uploads and stores the room image,
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);
    
        DB::transaction(function () use ($request) {
            try {
                // Handle image upload
                $imagePath = null;
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = $image->storeAs('rooms', $imageName, 'public');
                    \Log::info('Image uploaded:', ['path' => $imagePath]);
                }

                // Create the room
                $room = new Room();
                $room->name = $request->name;
                $room->capacity = $request->capacity;
                $room->type_room = $request->type_room;
                $room->status = $request->status;
                $room->image = $imagePath; // Store the image path
                $room->save();
        
                // Log the saved room and check the ID
                \Log::info('Room after save:', $room->toArray());
                ActivityLogger::logRoom('Room created', $room, 'Room');
                
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
                
                // Delete uploaded image if room creation fails
                if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                    \Log::info('Deleted image due to room creation failure:', ['path' => $imagePath]);
                }
                
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

        // Debug the room data
        \Log::info('Edit room data:', [
            'room_id' => $room->id,
            'image_value' => $room->image,
            'image_type' => gettype($room->image),
            'image_empty' => empty($room->image)
        ]);

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', 
            'remove_image' => 'nullable|boolean',
        ]);
        
        // Update room details
        DB::transaction(function () use ($request, $id) {
            try {
                $room = Room::findOrFail($id);
                $oldImagePath = $room->image;

                // Handle image removal if requested
                if ($request->has('remove_image') && $request->remove_image) {
                    if ($oldImagePath) {
                        // Delete from storage
                        if (Storage::disk('public')->exists($oldImagePath)) {
                            Storage::disk('public')->delete($oldImagePath);
                            \Log::info('Image deleted by user request:', ['path' => $oldImagePath]);
                        }
                    }
                    $room->image = null;
                    \Log::info('Image set to null');
                }
                // Handle image upload if new image is provided
                elseif ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = $image->storeAs('rooms', $imageName, 'public');
                    \Log::info('Image uploaded:', ['path' => $imagePath]);
                    
                    // Delete old image if it exists
                    if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                        \Log::info('Old image deleted:', ['path' => $oldImagePath]);
                    }
                    
                    $room->image = $imagePath;
                }

                // Update the room details
                $room->name = $request->name;
                $room->capacity = $request->capacity;
                $room->type_room = $request->type_room;
                $room->status = $request->status;
                $room->save();

                // Log the updated room to check the changes
                \Log::info('Room after update:', $room->toArray());
                ActivityLogger::logRoom('Room updated', $room,'Room updated');
    
                // Update the furniture if available
                if (!empty($request->furniture)) {
                    \Log::info('Attaching furniture:', $request->furniture);
                    // Detach existing furniture before attaching new ones to avoid duplicates
                    $room->furnitures()->sync($request->furniture);  // `sync` will update the relationship
                } else {
                    $room->furnitures()->detach(); // Remove all furniture if none selected
                }

                // Update the electronic equipment if available
                if (!empty($request->electronicEquipment)) {
                    \Log::info('Attaching electronics:', $request->electronicEquipment);
                    // Detach existing electronics before attaching new ones
                    $room->electronics()->sync($request->electronicEquipment);  // `sync` will update the relationship
                } else {
                    $room->electronics()->detach(); // Remove all electronics if none selected
                }
            } catch (\Exception $e) {
                \Log::error('Error updating room:', ['error' => $e->getMessage()]);
                
                // Clean up newly uploaded image if update fails
                if ($request->hasFile('image') && isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                    \Log::info('Cleaned up failed upload:', ['path' => $imagePath]);
                }
                
                throw $e;  // Rethrow the exception
            }
        });
        
        return redirect()->route('backend.room.index')->with('success', 'Room updated successfully.');
    }

// Helper method to ensure storage link exists
    public function checkStorageLink()
    {
        $linkPath = public_path('storage');
        $targetPath = storage_path('app/public');
        
        if (!is_link($linkPath)) {
            if (is_dir($linkPath)) {
                // If there's a directory instead of a symlink, remove it
                rmdir($linkPath);
            }
            
            // Create the symlink
            try {
                symlink($targetPath, $linkPath);
                \Log::info('Storage link created successfully');
                return true;
            } catch (\Exception $e) {
                \Log::error('Failed to create storage link:', ['error' => $e->getMessage()]);
                return false;
            }
        }
        
        return true;
    }

    /**
     * Deletes the specified room and its associated furniture, electronics, and image.
     *
     * This method removes the room with the given ID from the database.
     * Before deletion, it detaches any related furniture and electronics and deletes
     * the associated image file to ensure the integrity of the data and cleanup storage.
     * Upon successful deletion, it redirects to the room index page with a success message.
     *
     * @param int $id The ID of the room to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirects to the room index page with a success message.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the room is not found.
     */
    public function destroy($id)
    {
        $room = room::findOrFail($id);

        // Delete associated image file if it exists
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
            \Log::info('Room image deleted:', ['path' => $room->image]);
        }

        // Detach related furniture and electronics
        $room->furnitures()->detach();
        $room->electronics()->detach();
        
        ActivityLogger::logRoom('Room deleted', $room, 'Room deleted');
        $room->delete();
        
        return redirect()->route('backend.room.index')->with('success', 'Room deleted successfully.');
    }
}