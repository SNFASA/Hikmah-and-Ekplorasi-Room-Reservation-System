<?php

namespace App\Http\Controllers;

use App\Models\CategoryEquipment;
use Illuminate\Http\Request;

class CatergoryEqupmentController extends Controller
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
        $categories = CategoryEquipment::orderBy('id', 'ASC')->paginate(10);
        return view('backend.category.index', compact('categories','categories'));
    }

    public function create()
    {
        return view('backend.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories_equipment,name|max:255',
        ]);

        CategoryEquipment::create([
            'name' => $request->name,
        ]);

        return redirect()->route('backend.category.index')->with('success', 'Category added successfully.');
    }

    public function edit($id)
    {
        $categories = CategoryEquipment::findOrFail($id);
        return view('backend.category.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $categories = CategoryEquipment::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:categories_equipment,name,' . $id,
        ]);

        $categories->update([
            'name' => $request->name,
        ]);

        return redirect()->route('backend.category.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $categories = CategoryEquipment::findOrFail($id);
        $categories->delete();

        return redirect()->route('backend.category.index')->with('success', 'Category deleted successfully.');
    }
}
