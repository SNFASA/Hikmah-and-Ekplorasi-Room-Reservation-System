<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Student;
use App\Models\Staff;
use Auth;
use Session;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class FrontendController extends Controller
{
   
    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }

    public function home(){
        
    } 

    // Login
    public function login(){
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request){
        $data= $request->all();
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
            Session::put('user',$data['email']);
            request()->session()->flash('success','Successfully login');
            return redirect()->route('home');
        }
        else{
            request()->session()->flash('error','Invalid email and password pleas try again!');
            return redirect()->back();
        }
    }

    public function logout(){
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success','Logout successfully');
        return back();
    }

    public function register(){
        return view('frontend.pages.register');
    }
    public function registerSubmit(Request $request)
    {
        // Step 1: Validate user data, including type-specific fields
        $this->validate($request, [
            'no_matriks' => 'required|unique:users|max:255',
            'name' => 'required|max:255',
            'facultyOffice' => 'required|max:255',
            'course' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
        ]);
    
        // Step 2: Prepare data based on the user type
        $data = [
            'no_matriks' => $request->no_matriks,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'facultyOffice' => $request->facultyOffice ?? null,
            'course' => $request->course ?? null,
        ];
    
        // Step 3: Insert into users table
        $user = User::create($data);
    
        if ($user) {
            // Step 4: Put email in session and redirect with success message
            Session::put('user', $user->email);
            request()->session()->flash('success', 'Successfully registered');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Please try again!');
            return back();
        }
    }    
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => $data['user_type'],             
            'no_matriks' => $data['no_matriks'] ?? null,   
            'facultyOffice' => $data['facultyOffice'] ?? null, 
            'course' => $data['course'] ?? null,           
        ]);
    }
    
    
    // Reset password
    public function showResetForm()
    {
        return view('auth.passwords.old-reset');
    }
    
    
}
