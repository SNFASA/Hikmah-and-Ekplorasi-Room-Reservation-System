<?php

namespace App\Http\Controllers;

use App\Models\electronic;
use Illuminate\Http\Request;
use App\Models\CategoryEquipment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ElectronicPPPController extends Controller
{
    // Constructor with middleware to restrict access to admins and PPP users

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || (!auth()->user()->isPpp())) {
                abort(403, 'Unauthorized access. Admins and PPP users only.');
            }
            return $next($request);
        });
    }
    // Display a listing of all bookingsup
    public function index()
    {
        $electronics = Electronic::orderBy('no_electronicEquipment', 'ASC')->paginate(10);
        return view('ppp.electronic.index')->with('electronics', $electronics);
    }
    

    // Show the form for creating a new booking
    public function create()
    {
        $categories = CategoryEquipment::orderBy('name')->get();
        return view('ppp.electronic.create', compact('categories'));
    }

    // Store a newly created electronics in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories_equipment,id',
            'status' => 'required|string|max:255',
        ]);
    
        Electronic::create([  // Correct model name is Electronic
            'name' => $request->name,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);
    
        return redirect()->route('ppp.electronic.index')->with('success', 'Electronic device created successfully.');
    }
    

    // Show the form for editing the specified electronics
    public function edit($id)
    {
        $electronics = electronic::findOrFail($id);
        $categories = CategoryEquipment::orderBy('name')->get();
        return view('ppp.electronic.edit', compact('electronics','categories'));
    }

    // Update the specified electronics in storage
    public function update(Request $request, $id)
    {
        $electronics = electronic::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories_equipment,id',
            'status' => 'required|string|max:255',
        ]);

        $electronics->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);

        return redirect()->route('ppp.electronic.index')->with('success', 'electronic device updated successfully.');
    }

    // Remove the specified electronics from storage
    public function destroy($id)
    {
        $electronics = electronic::findOrFail($id);
        $electronics->delete();

        return redirect()->route('ppp.electronic.index')->with('success', 'electronic device deleted successfully.');
    }
}
