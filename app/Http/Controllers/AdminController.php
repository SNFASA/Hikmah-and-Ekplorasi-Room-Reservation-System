<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Staff; // Use the Staff model for both controllers
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index() {
        $data = Staff::select(
                \DB::raw("COUNT(*) as count"), 
                \DB::raw("DAYNAME(created_at) as day_name"), 
                \DB::raw("DAY(created_at) as day")
            )
            ->where('created_at', '>', Carbon::today()->subDays(6)) // Change subDay to subDays
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
        
        $array[] = ['Name', 'Number'];
        foreach($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
    
        return view('backend.index')->with('staff', json_encode($array));
    }
    

    public function profile() {
        $profile = auth()->user(); // Fetch the authenticated user
        return view('backend.users.profile')->with('profile', $profile);
    }

    public function profileUpdate(Request $request, $id) {
        $staff = Staff::findOrFail($id);
        $data = $request->validate([  // Validate incoming request
            'no_staff' => 'required|max:255|unique:staff,no_staff,' . $id,
            'name' => 'required|max:255',
            'facultyOffice' => 'required|max:255',
            'role' => 'required|max:255',
            'email' => 'required|email|unique:staff,email,' . $id,
            'receive_notifications' => 'boolean',
        ]);
        
        $staff->fill($data)->save();
        request()->session()->flash('success', 'Successfully updated your profile');
        
        return redirect()->back();
    }

    public function settings() {
        $data = Setting::first();
        return view('backend.setting')->with('data', $data);
    }

    public function settingsUpdate(Request $request) {
        // Validate staff settings
        $this->validate($request, [
            'no_staff' => 'required|max:255|unique:staff,no_staff,' . auth()->user()->id, 
            'name' => 'required|max:255',
            'facultyOffice' => 'required|max:255',
            'role' => 'required|max:255',
            'email' => 'required|email|unique:staff,email,' . auth()->user()->id, 
            'receive_notifications' => 'boolean',
        ]);
        
        // Assuming you want to update the logged-in user's staff information
        $staff = Staff::findOrFail(auth()->user()->id);
        $data = $request->only(['no_staff', 'name', 'facultyOffice', 'role', 'email', 'receive_notifications']);
        
        // Fill staff data and save
        $staff->fill($data)->save();
        
        // Flash success message
        request()->session()->flash('success', 'Staff settings successfully updated.');
        
        // Redirect back to the settings page or wherever appropriate
        return redirect()->back();
    }
    

    public function changePassword() {
        return view('backend.layouts.changePassword');
    }

    public function changePasswordStore(Request $request) {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'min:6'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        Staff::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        return redirect()->route('admin')->with('success', 'Password successfully changed');
    }

    public function storageLink() {
        if (File::exists(public_path('storage'))) {
            File::delete(public_path('storage'));
        }
        
        try {
            Artisan::call('storage:link');
            request()->session()->flash('success', 'Successfully storage linked.');
        } catch (\Exception $exception) {
            request()->session()->flash('error', $exception->getMessage());
        }
        
        return redirect()->back();
    }
}
