<?php

namespace App\Http\Controllers;
use App\Models\Faculty_offices;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\ActivityLogger;
class FacultyOfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || (!auth()->user()->isAdmin() && !auth()->user()->isPpp())) {
                abort(403, 'Unauthorized access. Admins only.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $facultyOffices= faculty_offices::orderBy('no_facultyOffice', 'ASC')
            ->paginate(10);
        return response()->view('backend.facultyOffice.index', compact('facultyOffices'));

    }
    public function create()
    {
        return view('backend.facultyOffice.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:faculty_offices,name|max:255',
            'created_at' => now(),
            'updated_at' => now(),
            
        ]);

        $facultyOffice=Faculty_offices::create([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        ActivityLogger::logFaculty('created', $facultyOffice, 'Faculty office created');
        return redirect()->route('backend.facultyOffice.index')
            ->with('success', 'Faculty office added successfully.');
    }
    public function edit($id)
    {
        $facultyOffice = Faculty_offices::findOrFail($id);
        return view('backend.facultyOffice.edit', compact('facultyOffice'));
    }
    public function update(Request $request, $id)
    {
        $facultyOffice = Faculty_offices::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:faculty_offices,name,' . $id . ',no_facultyOffice',
            
        ]);

        $facultyOffice->update([
            'name' => $request->name,
            'updated_at' => now(),
            
        ]);
        ActivityLogger::logFaculty('updated', $facultyOffice, 'Faculty office updated');
        return redirect()->route('backend.facultyOffice.index')
            ->with('success', 'Faculty office updated successfully.');
    }
    public function destroy($id){
        $facultyOffice = Faculty_offices::findOrFail($id);
        $facultyOffice->delete();
        ActivityLogger::logFaculty('deleted', $facultyOffice, 'Faculty office deleted');
        return redirect()->route('backend.facultyOffice.index')
            ->with('success', 'Faculty office deleted successfully.');
    }
}

