<?php

namespace App\Http\Controllers;
use App\Models\furniture;
use App\Models\room;
use App\Models\electronic;
use App\Models\maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
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


    public function index()
    {
        $maintenance = maintenance::orderBy('id', 'ASC')->paginate(10);   
              // Assign `itemName` based on `itemType` for each maintenance record
              foreach ($maintenance as $maintenances) {
                if (strtolower($maintenances->itemType) == 'furniture') {
                    $maintenances->itemName = DB::table('furniture')
                        ->where('no_furniture', $maintenances->item_id)
                        ->value('name') ?? 'Unknown Furniture';
                } elseif (strtolower($maintenances->itemType) == 'electronic_equipment') {
                    $maintenances->itemName = DB::table('electronic_equipment')
                        ->where('no_electronicEquipment', $maintenances->item_id)
                        ->value('name') ?? 'Unknown Electronic Equipment';
                } elseif (strtolower($maintenances->itemType) == 'other') {
                    $maintenances->itemName = $maintenances->item_text ?? 'No Details Provided';
                } else {
                    $maintenances->itemName = 'Unknown';
                }
            }
            //dd($maintenance->items());

        return view('backend.maintenance.index')->with('maintenance', $maintenance);
    }
    

    public function create()
    {
        $rooms = room::all();
        $reported_by = auth()->user()->name;
        return view('backend.maintenance.create', compact( 'rooms','reported_by' ));
    }
   
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'itemType' => 'required|in:furniture,electronic_equipment,other',
            'itemid' => 'nullable|integer|required_unless:itemType,other', // Item ID only required unless 'other' is selected
            'itemid_text' => 'nullable|string|required_if:itemType,other|max:255', // Item name is required if 'other' is selected
            'room_id' => 'nullable|integer|exists:rooms,no_room',
            'date_maintenance' => 'required|date',
        ]);
    
        // Ensure that 'itemid' is set correctly or 'itemid_text' for 'other'
        if ($request->itemType == 'other' && !$request->itemid_text) {
            return redirect()->back()->withErrors(['itemid_text' => 'Item name is required for "Other".']);
        }
    
        Maintenance::create([
            'title' => $request->title,
            'description' => $request->description,
            'itemType' => $request->itemType,
            'item_id' => $request->itemType !== 'other' ? $request->itemid : null, // Only assign item_id if not 'other'
            'item_text' => $request->itemType === 'other' ? $request->itemid_text : null, // Assign item_text if 'other'
            'room_id' => $request->room_id,
            'date_maintenance' => $request->date_maintenance,
            'status' => 'pending',
            'reported_by' => auth()->id(),
        ]);
    
        return redirect()->route('backend.maintenance.index')->with('success', 'Maintenance report created successfully.');
    }
    // Show the form for editing the specified 
    public function edit($id)
    {   
        $maintenances = maintenance::findOrFail($id);
        $rooms = room::all();
        return view('backend.maintenance.edit', compact( 'rooms', 'maintenances' ));
    }

    // Update the specified electronics in storage
    public function update(Request $request, $id)
    {
        $maintenances = maintenance::findOrFail($id);
    
        // Dynamic validation rules based on itemType
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'itemType' => 'required|in:furniture,electronic_equipment,other',
            'itemid' => 'nullable|integer|required_unless:itemType,other|',
            'itemid_text' => 'nullable|string|required_if:itemType,other|max:255',
            'room_id' => 'nullable|integer|exists:rooms,no_room',
            'date_maintenance' => 'required|date',
        ]);

        // Update the maintenance record
        $maintenances->update([
            'title' => $request->title,
            'description' => $request->description,
            'itemType' => $request->itemType,
            'item_id' => $request->itemType !== 'other' ? $request->itemid : null,
            'item_text' => $request->itemType === 'other' ? $request->itemid_text : null,
            'room_id' => $request->room_id,
            'date_maintenance' => $request->date_maintenance,
            'status' => $request->status,
            'reported_by' => auth()->id(),
        ]);
    
        return redirect()->route('backend.maintenance.index')->with('success', 'Report updated successfully.');
    }
    // Remove the specified from storage
    public function destroy($id)
    {
        $maintenance = maintenance::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('backend.maintenance.index')->with('success', 'Report deleted successfully.');
    }
    public function getItems(Request $request)
    {
        $request->validate([
            'type' => 'required|in:furniture,electronic_equipment,other',
        ]);

        switch ($request->type) {
            case 'furniture':
                // Select the correct column names (primary key as no_furniture)
                $items = DB::table('furniture')
                    ->select('no_furniture as id', 'name')  // Aliasing to 'id'
                    ->where('status', 'Damage')
                    ->get();
                break;
            case 'electronic_equipment':
                // Select the correct column names (primary key as no_electronicEquipment)
                $items = DB::table('electronic_equipment')
                    ->select('no_electronicEquipment as id', 'name')  // Aliasing to 'id'
                    ->where('status', 'Damage')
                    ->get();
                break;
            case 'other':
                $items = [];  // No items for 'other'
                break;
            default:
                return response()->json([], 400); // Bad Request
        }
        
        return response()->json($items);
    }

}
