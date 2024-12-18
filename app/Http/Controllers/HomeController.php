<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Hash;
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

     public function index(Request $request)
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
             // You can directly use the 24-hour formatted time
             $query->whereDoesntHave('schedule', function ($q) use ($date, $start_time, $end_time) {
                 $q->where('invalid_date', $date)
                   ->where(function ($q2) use ($start_time, $end_time) {
                       $q2->whereBetween('invalid_time_start', [$start_time, $end_time])
                           ->orWhereBetween('invalid_time_end', [$start_time, $end_time]);
                   });
             });
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
     
         // Pass variables to the view
         return view('frontend.index', compact(
             'rooms', 'type_room', 'date', 'start_time', 'end_time',
             'furniture_category', 'electronic_category', 'furnitureCategories', 'electronicCategories'
         ));
     }
     
     
    public function bookingform(){
        return view('frontend.pages.bookingform');
    }

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('user.users.profile')->with('profile',$profile);
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
        return view('user.layouts.userPasswordChange');
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
