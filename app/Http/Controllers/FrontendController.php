<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\room;
use App\Helper;
use App\Models\furniture;
use App\Models\electronic;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class FrontendController extends Controller
{
    /**
     * Check if the user has access to the frontend pages. If not, throw a 403
     * error. This middleware is applied to all methods in this controller.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Allow access if the user is either an admin, a user, or a PPP
            if (!auth()->user() || 
                (!auth()->user()->isAdmin() && !auth()->user()->isUser() && !auth()->user()->isPpp())) {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }
    // Redirect user based on role
    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }
    // Home method
    /**
     * Display the home page with initial data.
     *
     * This method initializes the data required for the home page view.
     * It sets up empty collections and default values for various parameters
     * such as room type, date, start time, end time, and categories for furniture
     * and electronics. It then retrieves the categories for furniture and electronics
     * from their respective models and passes all the data to the frontend index view.
     *
     * @return \Illuminate\View\View The view for the home page with the initialized data.
     */
    public function home()
    {
    
        $rooms = collect(); // Empty collection as a placeholder
        $type_room = 'All'; // Default value for type_room
        $date = null;
        $start_time = null;
        $end_time = null;
        $furniture_category = [];
        $electronic_category = [];
        $furnitureCategories = Furniture::getFurnitureCategories();
        $electronicCategories = Electronic::getElectronicCategories();
        return view('frontend.index', compact('rooms', 'type_room', 
        'date', 'start_time', 'end_time', 'furniture_category', 'electronic_category',
        'furnitureCategories', 'electronicCategories'));
    }
    
    
    public function bookingform(){
        
        return view('frontend.pages.bookingform');
    }
    

    // Show login form
    public function login()
    {
        return view('frontend.pages.login');
    }

    // Handle login submission
    public function loginSubmit(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($data)) {
            $request->session()->flash('success', 'Successfully logged in');
            return redirect()->route('home'); // Redirect to the shared home page
        } else {
            $request->session()->flash('error', 'Invalid email or password. Please try again!');
            return back();
        }
    }
    

    // Logout the user
    public function logout()
    {
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success', 'Logged out successfully');
        return redirect()->route('login');
    }

    // Show register form
    public function register()
    {
        return view('frontend.pages.register');
    }

    // Handle register submission
    public function registerSubmit(Request $request)
    {
        // Validate user data
        $data = $request->validate([
            'no_matriks' => 'required|unique:users|max:255',
            'name' => 'required|max:255',
            'facultyOffice' => 'required|max:255',
            'course' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
        ]);

        // Create the user
        $user = User::create([
            'no_matriks' => $data['no_matriks'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'facultyOffice' => $data['facultyOffice'],
            'course' => $data['course'],
        ]);

        if ($user) {
            // Store email in session and redirect with success message
            Session::put('user', $user->email);
            $request->session()->flash('success', 'Successfully registered');
            return redirect()->route('home');
        } else {
            $request->session()->flash('error', 'Registration failed. Please try again!');
            return back();
        }
    }

    // Custom password reset form
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
    
                event(new PasswordReset($user));
            }
        );
    
        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login.form')->with('success', __($status));
        }
    
        return back()->withErrors(['email' => __($status)]);
    }
    public function profile() {
        // Fetch the authenticated user's profile data
        $profile = auth()->user(); // Fetch the authenticated user
        $facultyOffices = DB::table('faculty_Offices')->get(); // Get all faculty offices
        $courses = DB::table('courses')->get(); // Get all courses
        return view('frontend.pages.profile', compact('profile', 'facultyOffices', 'courses'));
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
            'role' => 'user',
        ]);
    
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
    
        $user->fill($data)->save();
    
        session()->flash('success', 'Successfully updated your profile');
    
        return redirect()->route('user-profile')->with('success', 'Profile updated successfully');
    }
    
    public function changePassword() {
        return view('frontend.layouts.userPasswordChange');
    }
    
    public function changPasswordStore(Request $request) {
        // Validate and change password logic
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
    
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
    
        $user->update(['password' => Hash::make($request->password)]);
    
        return redirect()->route('user-profile')->with('success', 'Password changed successfully');
    }


}
