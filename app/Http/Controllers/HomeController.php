<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\bookings;
use App\Rules\MatchOldPassword;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use App\Models\room;
use Carbon\Carbon;
use App\Models\furniture;
use Illuminate\Support\Facades\Log;
use App\Models\electronic;
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
     * Display the home page with room availability and filters.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * This method handles the following:
     * - Retrieves filter inputs from the request.
     * - Validates the consistency of start and end times.
     * - Checks for schedule conflicts with unavailable times and existing bookings.
     * - Queries the `rooms` table based on the provided filters.
     * - Retrieves furniture and electronic categories for filters.
     * - Returns the view with the filtered rooms and categories.
     *
     * Request Inputs:
     * - type_room: string (default: 'All')
     * - date: string (optional)
     * - start_time: string (optional)
     * - end_time: string (optional)
     * - furniture_category: array (optional)
     * - electronic_category: array (optional)
     *
     * Responses:
     * - JSON error response if start and end times are inconsistent.
     * - JSON error response if there is a schedule conflict.
     * - View with filtered rooms and categories.
     */
    public function index(Request $request)
    {
        $type_room = $request->input('type_room', 'All');
        $date = $request->input('date');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        $furniture_category = $request->input('furniture_category', []);
        $electronic_category = $request->input('electronic_category', []);
    
        // Validasi jika start_time dan end_time tidak konsisten
        if (($start_time && !$end_time) || (!$start_time && $end_time)) {
            request()->session()->flash('error', 'Both start and end time must be provided.');
            return redirect()->back();
        }
    
        // Query asas bilik yang aktif & tapis ikut input
        $rooms = room::query()
            ->where('status', 'valid')
            ->when($type_room !== 'All', function ($query) use ($type_room) {
                $query->where('type_room', $type_room);
            })
            ->when(!empty($furniture_category), function ($query) use ($furniture_category) {
                $query->whereHas('furnitures', function ($q) use ($furniture_category) {
                    $q->whereIn('category', $furniture_category);
                });
            })
            ->when(!empty($electronic_category), function ($query) use ($electronic_category) {
                $query->whereHas('electronics', function ($q) use ($electronic_category) {
                    $q->whereIn('category', $electronic_category);
                });
            })
            ->get();
    
        // Validasi konflik masa berdasarkan setiap bilik
        if ($date && $start_time && $end_time) {
            foreach ($rooms as $room) {
                $roomId = $room->no_room;
    
                // Semak konflik dengan jadual tidak tersedia
                $conflictWithUnavailable = DB::table('schedule_booking')
                    ->where('roomid', $roomId)
                    ->where('invalid_date', $date)
                    ->where(function ($q) use ($start_time, $end_time) {
                        $q->where('invalid_time_start', '<', $end_time)
                          ->where('invalid_time_end', '>', $start_time);
                    })
                    ->exists();
    
                if ($conflictWithUnavailable) {
                    request()->session()->flash('error', "Room $roomId is unavailable at the selected time.");
                    return redirect()->back();
                }
    
                // Semak konflik dengan tempahan lain
                $conflictWithBooked = DB::table('bookings')
                    ->where('no_room', $roomId)
                    ->where('booking_date', $date)
                    ->where(function ($q) use ($start_time, $end_time) {
                        $q->where('booking_time_start', '<', $end_time)
                          ->where('booking_time_end', '>', $start_time);
                    })
                    ->exists();
    
                if ($conflictWithBooked) {
                    request()->session()->flash('error', "Room $roomId is already booked at the selected time.");
                    return redirect()->back();
                }
            }
        }
    
        // Data untuk paparan filter
        $furnitureCategories = furniture::getFurnitureCategories();
        $electronicCategories = electronic::getElectronicCategories();
    
        // Return view
        return view('frontend.index', compact(
            'rooms', 'furnitureCategories', 'electronicCategories',
            'type_room', 'date', 'start_time', 'end_time',
            'furniture_category', 'electronic_category'
        ));
    }
    
      
    public function profile(){
        $profile=Auth()->user();
        return view('frontend.pages.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request,$id){
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