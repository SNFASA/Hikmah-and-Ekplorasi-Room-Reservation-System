<?php

namespace App\Http\Controllers;

use App\Models\TypeRooms;
use Illuminate\Http\Request;

class TypeRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || (!auth()->user()->isAdmin() && !auth()->user()->isPpp())) {
                abort(403, 'Unauthorized access. Admins .');
            }
            return $next($request);
        });
    }
    public function index()
    {
        $types = TypeRooms::orderBy('name')->paginate(10);
        $type = TypeRooms::orderBy('id', 'ASC')->paginate(10);
        return view('backend.type_room.index', compact('types','type'));
    }

    public function create()
    {
        return view('backend.type_room.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:type_rooms,name|max:255',
            'form_type' => 'required|in:Standard,Meeting seminar',
        ]);

        TypeRooms::create([
            'name' => $request->name,
            'form_type' => $request->form_type,
        ]);

        return redirect()->route('backend.type_room.index')->with('success', 'Room type added successfully.');
    }

    public function edit($id)
    {
        $type = TypeRooms::findOrFail($id);
        return view('backend.type_room.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = TypeRooms::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:type_rooms,name,' . $id,
            'form_type' => 'required|in:Standard,Meeting seminar',
        ]);

        $type->update([
            'name' => $request->name,
            'form_type' => $request->form_type,
        ]);

        return redirect()->route('backend.type_room.index')->with('success', 'Room type updated successfully.');
    }

    public function destroy($id)
    {
        $type = TypeRooms::findOrFail($id);
        $type->delete();

        return redirect()->route('backend.type_room.index')->with('success', 'Room type deleted successfully.');
    }
}
