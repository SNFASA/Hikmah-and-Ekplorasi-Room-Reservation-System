<?php

namespace App\Http\Controllers;

use App\Models\electronic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ElectronicController extends Controller
{
    // Constructor with middleware to restrict access to admins and PPP users

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || (!auth()->user()->isAdmin() && !auth()->user()->isPpp())) {
                abort(403, 'Unauthorized access. Admins and PPP users only.');
            }
            return $next($request);
        });
    }
    // Display a listing of all bookingsup
    public function index()
    {
        $electronics = Electronic::orderBy('no_electronicEquipment', 'ASC')->paginate(10);
        return view('backend.electronic.index')->with('electronics', $electronics);
    }
    

    // Show the form for creating a new booking
    public function create()
    {
        return view('backend.electronic.create');
    }

    // Store a newly created electronics in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);
    
        Electronic::create([  // Correct model name is Electronic
            'name' => $request->name,
            'category' => $request->category,
            'status' => $request->status,
        ]);
    
        return redirect()->route('backend.electronic.index')->with('success', 'Electronic device created successfully.');
    }
    

    // Show the form for editing the specified electronics
    public function edit($id)
    {
        $electronics = electronic::findOrFail($id);
        return view('backend.electronic.edit', compact('electronics'));
    }

    // Update the specified electronics in storage
    public function update(Request $request, $id)
    {
        $electronics = electronic::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $electronics->update([
            'name' => $request->name,
            'category' => $request->category,
            'status' => $request->status,
        ]);

        return redirect()->route('backend.electronic.index')->with('success', 'electronic device updated successfully.');
    }

    // Remove the specified electronics from storage
    public function destroy($id)
    {
        $electronics = electronic::findOrFail($id);
        $electronics->delete();

        return redirect()->route('backend.electronic.index')->with('success', 'electronic device deleted successfully.');
    }
}
