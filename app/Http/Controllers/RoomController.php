<?php

namespace App\Http\Controllers;
use App\Models\room;
use Illuminate\Http\Request;

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
        $rooms = room::orderBy('no_room', 'ASC')->paginate(10);
        return view('backend.room.index')->with('rooms', $rooms);
    }
    

    public function create()
    {
        $categories = [
            'Desk',
            'Chair',
            'Japaness Table',
            'Whiteboard'
        ];
        return view('backend.room.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:Desk,Chair,Japaness Table,Whiteboard',
            'status' => 'required|string|max:255',
        ]);
        
        room::create([  
            'name' => $request->name,
            'category' => $request->category,
            'status' => $request->status,
        ]);
    
        return redirect()->route('backend.room.index')->with('success', 'Room created successfully.');
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
        $rooms = room::findOrFail($id);
        return view('backend.room.edit', compact('rooms', 'categories'));
    }

    // Update the specified electronics in storage
    public function update(Request $request, $id)
    {
        $rooms = room::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:Desk,Chair,Japaness Table,Whiteboard', 
            'status' => 'required|string|max:255',
        ]);
        

        $rooms->update([
            'name' => $request->name,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        return redirect()->route('backend.room.index')->with('success', 'Room updated successfully.');
    }

    // Remove the specified from storage
    public function destroy($id)
    {
        $rooms = room::findOrFail($id);
        $rooms->delete();

        return redirect()->route('backend.room.index')->with('success', 'Room deleted successfully.');
    }
}
