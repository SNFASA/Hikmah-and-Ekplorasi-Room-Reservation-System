<?php

namespace App\Http\Controllers;
use App\Models\courses;
use App\Models\department;
use Illuminate\Http\Request;

class CourseController extends Controller
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
        $crs = Courses::with('department')
            ->orderBy('no_course', 'ASC')
            ->paginate(10);
        return response()->view('backend.course.index', compact('crs'));
    }
    public function create()
    {
       $dpt=department::orderby('name')->get();
        return view('backend.course.create', compact('dpt'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:courses,name|max:255',
            'department_id' => 'required|exists:departments,no_department',
        ]);

        Courses::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('backend.course.index')
            ->with('success', 'Course added successfully.');
    }

    public function edit($id)
    {
        $crs = courses::findOrFail($id);
        $crss = courses::all();
        $dpt=department::orderby('name')->get();
        return view('backend.course.edit', compact('crs', 'crss', 'dpt'));
    }
    public function update(Request $request, $id)
    {
         $crs = courses::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name,' . $id . ',no_course',
            'department_id' => 'required|exists:departments,no_department',
        ]);

        $crs->update([
            'name' => $request->name,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('backend.course.index')->with('success', 'course updated successfully.');
    }
    public function destroy($id){
        $crs = courses::findOrFail($id);
        $crs->delete();
        return redirect()->route('backend.course.index')->with('success', 'course deleted successfully.');

    }
}
