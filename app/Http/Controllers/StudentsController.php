<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentsController extends Controller
{
    // Display a listing of students
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    // Show the form for creating a new student
    public function create()
    {
        return view('students.create');
    }

    // Store a newly created student in storage
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'no_matriks' => 'required|unique:students|max:255',
            'name' => 'required|max:255',
            'facultyOffice' => 'required|max:255',
            'course' => 'required|max:255',
            'email' => 'required|email|unique:students|max:255',
            'password' => 'required|min:6|confirmed',
            'receive_notifications' => 'boolean',
        ]);

        // Create a new student
        Student::create([
            'no_matriks' => $request->no_matriks,
            'name' => $request->name,
            'facultyOffice' => $request->facultyOffice,
            'course' => $request->course,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'receive_notifications' => $request->receive_notifications ?? false,
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    // Display the specified student
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('students.show', compact('student'));
    }

    // Show the form for editing the specified student
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    // Update the specified student in storage
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'no_matriks' => 'required|max:255|unique:students,no_matriks,' . $id,
            'name' => 'required|max:255',
            'facultyOffice' => 'required|max:255',
            'course' => 'required|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'receive_notifications' => 'boolean',
        ]);

        $student = Student::findOrFail($id);
        $student->no_matriks = $request->no_matriks;
        $student->name = $request->name;
        $student->facultyOffice = $request->facultyOffice;
        $student->course = $request->course;
        $student->email = $request->email;

        // Update password if provided
        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        $student->receive_notifications = $request->receive_notifications ?? false;
        $student->save();

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    // Remove the specified student from storage
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
