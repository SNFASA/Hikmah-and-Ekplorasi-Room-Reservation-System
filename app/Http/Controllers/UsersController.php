<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\ActivityLogger;
class UsersController extends Controller
{
    // Display a listing of users
    public function index()
    {
        $totalUsers = User::count();
        $userCount  = User::where('role', 'user')->count();
        $pppCount   = User::where('role', 'ppp')->count();
        $adminCount = User::where('role', 'admin')->count();

        $users = User::orderBy('id', 'ASC')->paginate(10);

        return view('backend.users.index', compact(
            'users', 'totalUsers', 'userCount', 'pppCount', 'adminCount'
        ));
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
            'no_matriks' => 'required|unique:users,no_matriks|max:255',
            'name' => 'required|max:255',
            'facultyOffice' => 'nullable|max:255',
            'course' => 'nullable|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:user,admin,ppp',
        ]);

        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        \Log::info('Role being inserted: ' . $request->role);

        $status = User::create($data);
        ActivityLogger::logUser('created', $status);
        if ($status) {
            request()->session()->flash('success', 'Successfully added new User');
        } else {
            request()->session()->flash('error', 'Error occurred while adding new user');
        }
        
        return redirect()->route('users.index'); // Adjust the route name as necessary
    }

    // Display the specified student
    public function show($id)
    {
        $users = User::findOrFail($id);
        return view('backend.users.show')->with('users', $users);
    }

    // Show the form for editing the specified student
    public function edit($id)
    {
        $users = User::findOrFail($id);
        return view('backend.users.edit')->with('users', $users);
    }

    // Update the specified student in storage
    public function update(Request $request, $id)
    {
        $users = User::findOrFail($id);

        $this->validate($request, [
            'no_matriks' => 'required|max:255|unique:users,no_matriks,' . $id,
            'name' => 'required|max:255',
            'facultyOffice' => 'nullable|max:255',
            'course' => 'nullable|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required',
        ]);

        $data = $request->all();

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $status = $users->fill($data)->save();
        ActivityLogger::logUser('updated', $users);
        if ($status) {
            request()->session()->flash('success', 'Successfully updated user');
        } else {
            request()->session()->flash('error', 'Error occurred while updating user');
        }
        
        return redirect()->route('users.index'); // Adjust the route name as necessary
    }

    // Remove the specified student from storage
    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $status = $users->delete();
        ActivityLogger::logUser('deleted', $users);
        if ($status) {
            request()->session()->flash('success', 'Student successfully deleted');
        } else {
            request()->session()->flash('error', 'There was an error while deleting user');
        }

        return redirect()->route('users.index'); // Adjust the route name as necessary
    }
}
