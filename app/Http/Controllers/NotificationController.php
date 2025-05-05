<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
class NotificationController extends Controller
{
    public function index(){
        return view('backend.notification.index');
    }
    public function show(Request $request)
    {
        $notification = auth()->user()->notifications()->where('id', $request->id)->first();
    
        if ($notification) {
            $notification->markAsRead();
    
            // Check if actionURL exists in notification data
            if (isset($notification->data['actionURL'])) {
                return redirect($notification->data['actionURL']);
            }
        }
    
        // Default fallback if no actionURL or notification
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin')
            : redirect()->route('home'); // for normal users
    }
    
    public function delete($id){
        $notification=Notification::find($id);
        if($notification){
            $status=$notification->delete();
            if($status){
                request()->session()->flash('success','Notification successfully deleted');
                return back();
            }
            else{
                request()->session()->flash('error','Error please try again');
                return back();
            }
        }
        else{
            request()->session()->flash('error','Notification not found');
            return back();
        }
    }
}
