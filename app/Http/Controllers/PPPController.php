<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\maintenance;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Admin;
use Carbon\Carbon;

class PPPController extends Controller
{
    public function index() {
        // Data for Furniture (Count by category)
        $furnitureData = DB::table('furniture')
            ->select(DB::raw('category, COUNT(*) as count'))
            ->groupBy('category')
            ->get();
    
        // Data for Electronic Equipment (Count by category)
        $electronicData = DB::table('electronic_equipment')
            ->select(DB::raw('category, COUNT(*) as count'))
            ->groupBy('category')
            ->get();
    
        // Data for Maintenance (Count by status)
        $maintenanceData = DB::table('maintenance')
            ->select(DB::raw('status, COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->toArray();
    
        return view('ppp.index', [
            'furniture' => $furnitureData,
            'electronic' => $electronicData,
            'maintenance' => $maintenanceData,
        ]);
    }
    
    
    
    // Profile Page
    public function profile() {
        $profile = auth()->user(); // Fetch the authenticated user
        $facultyOffices = DB::table('faculty_Offices')->get(); // Get all faculty offices
        $courses = DB::table('courses')->get(); // Get all courses
        return view('ppp.users.profile', compact('profile', 'courses', 'facultyOffices')); // Return the profile view
    }
    
    public function profileUpdate(Request $request, $id) {
        $user = User::findOrFail($id);
    
        $data = $request->validate([  
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'no_matriks' => 'required|max:255|unique:users,no_matriks,' . $id,
            'facultyOffice' => 'required|max:255',
            'course' => 'required|max:255',
            'password' => 'nullable|min:8|confirmed',
            'role' => 'ppp',
        ]);
    
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
    
        $user->fill($data)->save();
    
        session()->flash('success', 'Successfully updated your profile');
    
        return redirect()->route('ppp-profile');
    }
    
    
    public function changePassword() {
        return view('ppp.layouts.changePassword');
    }
    
    public function changePasswordStore(Request $request) {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'min:6'],
            'new_confirm_password' => ['same:new_password'],
        ]);
    
        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
    
        return redirect()->route('ppp-profile')->with('success', 'Password successfully changed');
    }
    public function storageLink(){
        // check if the storage folder already linked;
        if(File::exists(public_path('storage'))){
            // removed the existing symbolic link
            File::delete(public_path('storage'));

            //Regenerate the storage link folder
            try{
                Artisan::call('storage:link');
                request()->session()->flash('success', 'Successfully storage linked.');
                return redirect()->back();
            }
            catch(\Exception $exception){
                request()->session()->flash('error', $exception->getMessage());
                return redirect()->back();
            }
        }
        else{
            try{
                Artisan::call('storage:link');
                request()->session()->flash('success', 'Successfully storage linked.');
                return redirect()->back();
            }
            catch(\Exception $exception){
                request()->session()->flash('error', $exception->getMessage());
                return redirect()->back();
            }
        }
    }
    public function userPieChart(Request $request){
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDays(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
        $array[] = ['Name', 'Number'];
        foreach($data as $key => $value)
        {
            $array[++$key] = [$value->day_name, $value->count];
        }
     return view('ppp.index')->with('course', json_encode($array));
    }
    public function itemStatusPieChart(Request $request)
    {
        // Fetch data for furniture and electronic items based on status
        $data = maintenance::select(
            \DB::raw("COUNT(*) as count"), 
            'status'
        )
        ->whereIn('itemType', ['furniture','electronic_equipment','other']) // Filter by type
        ->groupBy('status') // Group by status
        ->orderBy('status') // Optional ordering by status
        ->get();
    
        // Prepare data array for the chart
        $array[] = ['Status', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->status, $value->count];
        }
    
        // Pass the data to the view
        return view('ppp.index')->with('course', json_encode($array));
    }
    
}
