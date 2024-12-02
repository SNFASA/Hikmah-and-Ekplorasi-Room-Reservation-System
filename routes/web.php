<?php

use App\Http\Controllers\ElectronicController;
use App\Models\room;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\FurnitureController;
use App\Http\Controllers\UsersController;

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
Route::get('/', [HomeController::class, 'index'])->name('user')->middleware('auth');
Route::get('/home', [FrontendController::class, 'home'])->name('home');
// Bookings
Route::prefix('/admin/bookings')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('backend.booking.index');
    Route::get('/create', [BookingController::class, 'create'])->name('backend.booking.create');
    Route::post('/', [BookingController::class, 'store'])->name('backend.booking.store');
    Route::get('/{id}', [BookingController::class, 'show'])->name('backend.booking.show');
    Route::get('/{id}/edit', [BookingController::class, 'edit'])->name('backend.booking.edit');
    Route::put('/{id}', [BookingController::class, 'update'])->name('backend.booking.update');
    Route::delete('/{id}', [BookingController::class, 'destroy'])->name('backend.booking.destroy');
    Route::get('/booking', [BookingController::class, 'roomChart'])->name('backend.booking.Chart');
});

//electronic 
Route::prefix('/admin/electronics')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [ElectronicController::class, 'index'])->name('backend.electronic.index');
    Route::get('/create', [ElectronicController::class, 'create'])->name('backend.electronic.create');
    Route::post('/', [ElectronicController::class, 'store'])->name('backend.electronic.store');
    Route::get('/{id}', [ElectronicController::class, 'show'])->name('backend.electronic.show');
    Route::get('/{id}/edit', [ElectronicController::class, 'edit'])->name('backend.electronic.edit');
    Route::put('/{id}', [ElectronicController::class, 'update'])->name('backend.electronic.update');
    Route::delete('/{id}', [ElectronicController::class, 'destroy'])->name('backend.electronic.destroy');
});

//furniture 
Route::prefix('/admin/furnitures')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [FurnitureController::class, 'index'])->name('backend.furniture.index');
    Route::get('/create', [FurnitureController::class, 'create'])->name('backend.furniture.create');
    Route::post('/', [FurnitureController::class, 'store'])->name('backend.furniture.store');
    Route::get('/{id}', [FurnitureController::class, 'show'])->name('backend.furniture.show');
    Route::get('/{id}/edit', [FurnitureController::class, 'edit'])->name('backend.furniture.edit');
    Route::put('/{id}', [FurnitureController::class, 'update'])->name('backend.furniture.update');
    Route::delete('/{id}', [FurnitureController::class, 'destroy'])->name('backend.furniture.destroy');
});

//room 
Route::prefix('/admin/rooms')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [RoomController::class, 'index'])->name('backend.room.index');
    Route::get('/create', [RoomController::class, 'create'])->name('backend.room.create');
    Route::post('/', [RoomController::class, 'store'])->name('backend.room.store');
    Route::get('/{id}', [RoomController::class, 'show'])->name('backend.room.show');
    Route::get('/{id}/edit', [RoomController::class, 'edit'])->name('backend.room.edit');
    Route::put('/{id}', [RoomController::class, 'update'])->name('backend.room.update');
    Route::delete('/{id}', [RoomController::class, 'destroy'])->name('backend.room.destroy');
});


// Admin Section
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('backend.index');
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/file-manager', function () {
        return view('backend.layouts.file-manager');
    })->name('file-manager');
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
    

    // User Management
    Route::resource('users', UsersController::class);

    //profile 
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin-profile');
    Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('profile-update');

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
    Route::resource('/admin/bookings', BookingController::class);

    //electronic
    Route::resource('/admin/electronic', ElectronicController::class);

    //furniture 
    Route::resource('/admin/furniture', FurnitureController::class);

    //room
    Route::resource('/admin/room', RoomController::class);
});

// User Section
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [FrontendController::class, 'home'])->name('home');
    Route::get('/profile', [HomeController::class, 'profile'])->name('user-profile');
    Route::post('/profile/{id}', [HomeController::class, 'profileUpdate'])->name('user-profile-update');
    Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
    Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');
});
