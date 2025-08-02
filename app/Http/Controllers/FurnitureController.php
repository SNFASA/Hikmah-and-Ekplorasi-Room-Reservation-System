<?php

namespace App\Http\Controllers;
use App\Models\furniture;
use App\Models\CategoryEquipment;
use Illuminate\Http\Request;

class FurnitureController extends Controller
{


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || (!auth()->user()->isAdmin() && !auth()->user()->isPpp())) {
                 abort(403, 'Unauthorized access. Admins and PPP users only.');
            }
            return $next($request);
        });
    }



/**
 * Display a paginated list of furniture items ordered by furniture number.
 *
 * @return \Illuminate\View\View The view displaying the list of furniture items.
 */

    public function index()
    {
        $furniture = furniture::orderBy('no_furniture', 'ASC')->paginate(10);
        return view('backend.furniture.index')->with('furniture', $furniture);
    }
    

    /**
     * Show the form for creating a new furniture item.
     * @return \Illuminate\View\View The view displaying the form for creating a new furniture item.
     */
    public function create()
    {
        $categories = CategoryEquipment::orderBy('name')->get();
        return view('backend.furniture.create', compact('categories'));
    }


    /**
     * Store a newly created furniture item in storage.
     * @param \Illuminate\Http\Request $request The request instance containing the data for the new furniture item.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the list of furniture items with a success message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories_equipment,id',
            'status' => 'required|string|max:255',
        ]);
        
        furniture::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'status' => $request->status,
        ]);
    
        return redirect()->route('backend.furniture.index')->with('success', 'Furniture created successfully.');
    }
    

    // Show the form for editing the specified
    public function edit($id)
    {
        $categories = CategoryEquipment::orderBy('name')->get();
        $furniture = furniture::findOrFail($id);
        return view('backend.furniture.edit', compact('furniture', 'categories'));
    }

    // Update the specified electronics in storage
    public function update(Request $request, $id)
    {
        $furniture = furniture::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories_equipment,id',
            'status' => 'required|string|max:255',
        ]);
        

        $furniture->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
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
