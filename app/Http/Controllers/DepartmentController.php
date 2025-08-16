<?php

namespace App\Http\Controllers;
use App\Models\department;

use Illuminate\Http\Request;

class DepartmentController extends Controller
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
       $dpt = department::orderBy('no_department', 'ASC')->paginate(10);
        return response()->view('backend.department.index', compact('dpt'));
    }
    public function create()
    {
        return view('backend.department.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|String|unique:departments,name|max:255',
        ]);
        department::create([
            'name' => $request->name,
        ]);
        return redirect()->route('backend.department.index')->with('success', 'Department added successfully.');
    }
    public function edit($id)
    {
        $dpt = department::findOrFail($id);
        $dpts = department::all();
        return view('backend.department.edit', compact('dpt', 'dpts'));
    }
    public function update(Request $request, $id)
    {
         $dpt = department::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $id . ',no_department',
        ]);

        $dpt->update([
            'name' => $request->name,
        ]);

        return redirect()->route('backend.department.index')->with('success', 'Department updated successfully.');
    }
    public function destroy($id){
        $dpt = department::findOrFail($id);
        $dpt->delete();
        return redirect()->route('backend.department.index')->with('success', 'Department deleted successfully.');

    }
}

