<?php

namespace App\Http\Controllers;

use App\Models\staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    // Display a listing of students
    public function index()
    {
        $staff = staff::all();
        return view('staff.index', compact('staff'));
    }

    // Show the form for creating a new student
    public function create()
    {
        return view('staff.create');
    }

    // Store a newly created student in storage
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'no_staff' => 'required|unique:staff|max:255',
            'name' => 'required|max:255',
            'facultyOffice' => 'required|max:255',
            'role' => 'required|max:255',
            'email' => 'required|email|unique:staff|max:255',
            'password' => 'required|min:6|confirmed',
            'receive_notifications' => 'boolean',
        ]);

        // Create a new student
        staff::create([
            'no_matriks' => $request->no_matriks,
            'name' => $request->name,
            'facultyOffice' => $request->facultyOffice,
            'role' => $request->course,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'receive_notifications' => $request->receive_notifications ?? false,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
    }

    // Display the specified student
    public function show($id)
    {
        $staff = Staff::findOrFail($id);
        return view('staff.show', compact('staff'));
    }

    // Show the form for editing the specified student
    public function edit($id)
    {
        $staff = staff::findOrFail($id);
        return view('staff.edit', compact('staff'));
    }

    // Update the specified student in storage
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'no_staff' => 'required|max:255|unique:staff,no_staff,' . $id,
            'name' => 'required|max:255',
            'facultyOffice' => 'required|max:255',
            'role' => 'required|max:255',
            'email' => 'required|email|max:255|unique:staff,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'receive_notifications' => 'boolean',
        ]);

        $staff = staff::findOrFail($id);
        $staff->no_matriks = $request->no_matriks;
        $staff->name = $request->name;
        $staff->facultyOffice = $request->facultyOffice;
        $staff->role = $request->role;
        $staff->email = $request->email;

        // Update password if provided
        if ($request->filled('password')) {
            $staff->password = Hash::make($request->password);
        }

        $staff->receive_notifications = $request->receive_notifications ?? false;
        $staff->save();

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    // Remove the specified student from storage
    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
