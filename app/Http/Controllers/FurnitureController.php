<?php

namespace App\Http\Controllers;
use App\Models\furniture;
use Illuminate\Http\Request;

class FurnitureController extends Controller
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
        $furniture = furniture::orderBy('no_furniture', 'ASC')->paginate(10);
        return view('backend.furniture.index')->with('furniture', $furniture);
    }
    

    public function create()
    {
        $categories = [
            'Desk',
            'Chair',
            'Japaness Table',
            'Whiteboard'
        ];
        return view('backend.furniture.create', compact('categories'));
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
    
        return redirect()->route('backend.furniture.index')->with('success', 'Furniture created successfully.');
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
        return view('backend.furniture.edit', compact('furniture', 'categories'));
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

        return redirect()->route('backend.furniture.index')->with('success', 'furniture updated successfully.');
    }

    // Remove the specified from storage
    public function destroy($id)
    {
        $furniture = furniture::findOrFail($id);
        $furniture->delete();

        return redirect()->route('backend.furniture.index')->with('success', 'furniture deleted successfully.');
    }
}
