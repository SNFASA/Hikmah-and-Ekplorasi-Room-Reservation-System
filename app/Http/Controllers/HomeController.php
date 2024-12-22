<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bookings;
use App\Rules\MatchOldPassword;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use  Illuminate\Http\RedirectRespons;
use App\Models\Room;
use Carbon\Carbon;
use App\Models\Furniture;
use App\Models\Electronic;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function index(Request $request): Renderable
     {
         $query = Room::query();
         $furnitureCategories = Furniture::getFurnitureCategories();
         $electronicCategories = Electronic::getElectronicCategories();
         
         // Handle type_room filter
         $type_room = $request->get('type_room', 'All');
         if ($type_room !== 'All') {
             $query->where('type_room', $type_room);
         }
     
         $date = $request->get('date', null);
         $start_time = $request->get('start_time', null);
         $end_time = $request->get('end_time', null);
         if ($date && $start_time && $end_time) {
            $conflictWithUnavailable = DB::table('schedule_booking')
                ->where('invalid_date', $date)
                ->where(function ($query) use ($start_time, $end_time) {
                    $query->where('invalid_time_start', '<', $end_time)
                          ->where('invalid_time_end', '>', $start_time);
                })
                ->exists();
    
            if ($conflictWithUnavailable) {
                return back()->withErrors(['booking_time_start' => 'Selected time is unavailable due to schedule conflict.']);
            }
        }

         // Handle furniture_category filter
         $furniture_category = $request->get('furniture_category', []);
         if (!empty($furniture_category)) {
             $query->whereHas('furnitures', function ($q) use ($furniture_category) {
                 $q->whereIn('category', $furniture_category);
             });
         }
     
         // Handle electronic_category filter
         $electronic_category = $request->get('electronic_category', []);
         if (!empty($electronic_category)) {
             $query->whereHas('electronics', function ($q) use ($electronic_category) {
                 $q->whereIn('category', $electronic_category);
             });
         }
     
         $rooms = $query->get();
         \Log::info($query->toSql());

         // Pass variables to the view
         return view('frontend.index', compact(
             'rooms', 'type_room', 'date', 'start_time', 'end_time',
             'furniture_category', 'electronic_category', 'furnitureCategories', 'electronicCategories'
         ));
     }
     
     
     

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('frontend.pages.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request,$id){
        // return $request->all();
        $user=User::findOrFail($id);
        $data=$request->all();
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated your profile');
        }
        else{
            request()->session()->flash('error','Please try again!');
        }
        return redirect()->back();
    }
    public function changePassword(){
        return view('frontend.layouts.userPasswordChange');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return redirect()->route('user')->with('success','Password successfully changed');
    }

    
}
