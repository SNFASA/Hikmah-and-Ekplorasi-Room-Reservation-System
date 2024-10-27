<?php

namespace App\Http\Controllers;

use App\Models\Student; // Ensure this is the correct model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // Display a listing of students
    public function index()
    {
        $students = Student::orderBy('id', 'ASC')->paginate(10);
        return view('backend.users.index')->with('students', $students);
    }

    // Show the form for creating a new student
    public function create()
    {
        return view('backend.users.create');
    }

    // Store a newly created student in storage
    public function store(Request $request)
    {
        $this->validate($request, [
            'no_matriks' => 'required|unique:students|max:255',
            'name' => 'required|max:255',
            'facultyOffice' => 'required|max:255',
            'course' => 'required|max:255',
            'email' => 'required|email|unique:students|max:255',
            'password' => 'required|min:6|confirmed',
            'receive_notifications' => 'boolean',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $status = Student::create($data);

        if ($status) {
            request()->session()->flash('success', 'Successfully added student');
        } else {
            request()->session()->flash('error', 'Error occurred while adding student');
        }
        
        return redirect()->route('users.index'); // Adjust the route name as necessary
    }

    // Display the specified student
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('backend.users.show')->with('student', $student);
    }

    // Show the form for editing the specified student
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('backend.users.edit')->with('student', $student);
    }

    // Update the specified student in storage
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $this->validate($request, [
            'no_matriks' => 'required|max:255|unique:students,no_matriks,' . $id,
            'name' => 'required|max:255',
            'facultyOffice' => 'required|max:255',
            'course' => 'required|max:255',
            'email' => 'required|email|max:255|unique:students,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'receive_notifications' => 'boolean',
        ]);

        $data = $request->all();

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $status = $student->fill($data)->save();

        if ($status) {
            request()->session()->flash('success', 'Successfully updated student');
        } else {
            request()->session()->flash('error', 'Error occurred while updating student');
        }
        
        return redirect()->route('users.index'); // Adjust the route name as necessary
    }

    // Remove the specified student from storage
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $status = $student->delete();

        if ($status) {
            request()->session()->flash('success', 'Student successfully deleted');
        } else {
            request()->session()->flash('error', 'There was an error while deleting student');
        }

        return redirect()->route('users.index'); // Adjust the route name as necessary
    }
}
