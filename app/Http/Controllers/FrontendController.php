<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;


class FrontendController extends Controller
{
    // Redirect user based on role
    public function index(Request $request)
    {
        if ($request->user()) {
            return redirect()->route($request->user()->role);
        }
        return redirect()->route('login');
    }

    // Home method
    public function home()
    {
        return view('frontend.pages.home');
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
            Session::put('user', Auth::user()->email);
            $request->session()->flash('success', 'Successfully logged in');
            return redirect()->route('home');
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
    
}
