<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Staff; 

use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Admin;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index() {
        // Data for pie chart
        $data = User::select(
                \DB::raw("COUNT(*) as count"), 
                \DB::raw("DAYNAME(created_at) as day_name"), 
                \DB::raw("DAY(created_at) as day")
            )
            ->where('created_at', '>', Carbon::today()->subDays(6)) 
            ->groupBy('day_name', 'day')
            ->orderBy('day')
            ->get();
    
        $array[] = ['Name', 'Number'];
        foreach($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }
    
        // Data for $users (example logic, adjust according to your model structure)
        $users = User::select(
            \DB::raw("COUNT(*) as count"), 
            \DB::raw("DAYNAME(created_at) as day_name"), 
            \DB::raw("DAY(created_at) as day")
        )
        ->where('created_at', '>', Carbon::today()->subDays(6))
        ->groupBy('day_name', 'day')
        ->orderBy('day')
        ->get();
    
        $usersArray[] = ['Day', 'Registered Users'];
        foreach($users as $key => $value) {
            $usersArray[++$key] = [$value->day_name, $value->count];
        }
    
        return view('backend.index', [
            'admin' => json_encode($array),
            'users' => json_encode($usersArray), // Pass the users data
        ]);
    }
    
    

    public function profile() {
        $profile = auth()->user(); // Fetch the authenticated user
        return view('backend.users.profile')->with('profile', $profile);
    }

    public function profileUpdate(Request $request, $id) {
        $user = User::findOrFail($id);
        $data = $request->validate([  // Validate incoming request
            'no_matriks' => 'required|max:255|unique:users,no_matriks,' . $id,
            'name' => 'required|max:255',
            'facultyOffice' => 'required|max:255',
            'course' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required',
        ]);
        
        $user->fill($data)->save();
        request()->session()->flash('success', 'Successfully updated your profile');
        
        return redirect()->back();
    }

    public function settings() {
        $data = Setting::first();
        if (!$data) {
            // If no settings exist, create default settings
            $data = Setting::create([
                'short_des' => '',
                'description' => '',
                'photo' => '',
                'logo' => '',
                'address' => '',
                'email' => '',
                'phone' => '',
            ]);
        }
        return view('backend.setting')->with('data', $data);
    }
    

    public function settingsUpdate(Request $request) {
        $this->validate($request, [
            'short_des' => 'required|string',
            'description' => 'required|string',
            'photo' => 'required',
            'logo' => 'required',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);
    
        $settings = Setting::first();
        if (!$settings) {
            $settings = new Setting(); // Create new settings if none exist
        }
    
        $settings->fill($request->all());
        $settings->save();
    
        request()->session()->flash('success', 'Setting successfully updated');
        return redirect()->route('admin');
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

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        return redirect()->route('admin')->with('success', 'Password successfully changed');
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
        // dd($request->all());
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
    //  return $data;
     return view('backend.index')->with('course', json_encode($array));
    }
}
