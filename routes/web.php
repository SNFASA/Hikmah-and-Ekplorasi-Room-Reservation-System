<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NotificationController;
use App\Http\Controllers\BookingController;

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Auth::routes(['register' => false]);

// User Login/Registration Routes
Route::get('user/login', [FrontendController::class, 'login'])->name('login.form');
Route::post('user/login', [FrontendController::class, 'loginSubmit'])->name('login.submit');
Route::get('user/logout', [FrontendController::class, 'logout'])->name('user.logout');
Route::get('user/register', [FrontendController::class, 'register'])->name('register.form');
Route::post('user/register', [FrontendController::class, 'registerSubmit'])->name('register.submit');

// Reset Password
Route::post('password-reset', [FrontendController::class, 'showResetForm'])->name('password.reset.custom');

// Socialite Login
Route::get('login/{provider}/', [LoginController::class, 'redirect'])->name('login.redirect');
Route::get('login/{provider}/callback/', [LoginController::class, 'Callback'])->name('login.callback');

// Cache Clear
Route::get('cache-clear', function () {
    Artisan::call('optimize:clear');
    request()->session()->flash('success', 'Successfully cache cleared.');
    return redirect()->back();
})->name('cache.clear');

// Storage Link
Route::get('storage-link', [AdminController::class, 'storageLink'])->name('storage.link');

// Home Route (Require Login)
Route::get('/', [FrontendController::class, 'home'])->name('home')->middleware('auth');

// User Section
Route::group(['prefix' => '/user', 'middleware' => ['user']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('user');
    Route::get('/profile', [HomeController::class, 'profile'])->name('user-profile');
    Route::post('/profile/{id}', [HomeController::class, 'profileUpdate'])->name('user-profile-update');
    Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
    Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');
});

// Bookings
Route::prefix('bookings')->middleware(['auth', 'user'])->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
    Route::get('/booking', [BookingController::class, 'roomChart'])->name('user.booking.Chart');
});

// Admin Section
Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('staff');
    Route::get('/file-manager', function () {
        return view('backend.layouts.file-manager');
    })->name('file-manager');

    // User Management
    Route::resource('users', UsersController::class);

    // Settings
    Route::get('settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('setting/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');

    // Notifications
    Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('admin.notification');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('all.notification');
    Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('notification.delete');

    // Password Change
    Route::get('change-password', [AdminController::class, 'changePassword'])->name('change.password.form');
    Route::post('change-password', [AdminController::class, 'changPasswordStore'])->name('change.password');

    // Bookings
    Route::resource('/bookings', BookingController::class);
});
