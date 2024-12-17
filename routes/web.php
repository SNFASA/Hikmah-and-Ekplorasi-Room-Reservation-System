<?php

use App\Http\Controllers\ElectronicController;
use App\Models\room;
use App\Http\Controllers\PPPController;
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
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ElectronicPPPController;
use App\Http\Controllers\FurniturePPPController;
use App\Http\Controllers\RoomPPPController;
use App\Http\Controllers\MaintenancePPPController;


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
Route::get('/home', [HomeController::class, 'index'])->name('home');

//User
Route::prefix('/users')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('backend.users.index');
    Route::get('/create', [UsersController::class, 'create'])->name('backend.users.create');
    Route::post('/', [UsersController::class, 'store'])->name('backend.users.store');
    Route::get('/{id}', [UsersController::class, 'show'])->name('backend.users.show');
    Route::get('/{id}/edit', [UsersController::class, 'edit'])->name('backend.users.edit');
    Route::put('/{id}', [UsersController::class, 'update'])->name('backend.users.update');
    Route::delete('/{id}', [UsersController::class, 'destroy'])->name('backend.users.destroy');
});
//schedule
Route::prefix('/admin/schedules')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [ScheduleController::class, 'index'])->name('backend.schedule.index'); 
    Route::get('/create', [ScheduleController::class, 'create'])->name('backend.schedule.create');
    Route::post('/', [ScheduleController::class, 'store'])->name('backend.schedule.store');
    Route::get('/{id}', [ScheduleController::class, 'show'])->name('backend.schedule.show');
    Route::get('/{id}/edit', [ScheduleController::class, 'edit'])->name('backend.schedule.edit');
    Route::put('/{id}', [ScheduleController::class, 'update'])->name('backend.schedule.update');
    Route::delete('/{id}', [ScheduleController::class, 'destroy'])->name('backend.schedule.destroy');


});
//bookings
Route::prefix('/admin/bookings')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('backend.booking.index'); 
    Route::get('/create', [BookingController::class, 'create'])->name('backend.booking.create');
    Route::post('/', [BookingController::class, 'store'])->name('backend.booking.store');
    Route::get('/{id}', [BookingController::class, 'show'])->name('backend.booking.show');
    Route::get('/{id}/edit', [BookingController::class, 'edit'])->name('backend.booking.edit');
    Route::put('/{id}', [BookingController::class, 'update'])->name('backend.booking.update');
    Route::delete('/{id}', [BookingController::class, 'destroy'])->name('backend.booking.destroy');
    Route::get('/booking', [BookingController::class, 'roomChart'])->name('backend.booking.Chart');
    Route::post('/bookings/remove-student', [BookingController::class, 'removeStudent'])->name('bookings.remove-student');
    Route::get('bookings/chart', [BookingController::class, 'getBookingsByMonth'])->name('bookings.getBookingsByMonth');


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
//electronic PPP 
Route::prefix('/ppp/electronics')->middleware(['auth', 'role:ppp'])->group(function () {
    Route::get('/', [ElectronicPPPController::class, 'index'])->name('ppp.electronic.index');
    Route::get('/create', [ElectronicPPPController::class, 'create'])->name('ppp.electronic.create');
    Route::post('/', [ElectronicPPPController::class, 'store'])->name('ppp.electronic.store');
    Route::get('/{id}', [ElectronicPPPController::class, 'show'])->name('ppp.electronic.show');
    Route::get('/{id}/edit', [ElectronicPPPController::class, 'edit'])->name('ppp.electronic.edit');
    Route::put('/{id}', [ElectronicPPPController::class, 'update'])->name('ppp.electronic.update');
    Route::delete('/{id}', [ElectronicPPPController::class, 'destroy'])->name('ppp.electronic.destroy');
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

//furniture PPP
Route::prefix('/ppp/furnitures')->middleware(['auth', 'role:ppp'])->group(function () {
    Route::get('/', [FurniturePPPController::class, 'index'])->name('ppp.furniture.index');
    Route::get('/create', [FurniturePPPController::class, 'create'])->name('ppp.furniture.create');
    Route::post('/', [FurniturePPPController::class, 'store'])->name('ppp.furniture.store');
    Route::get('/{id}', [FurniturePPPController::class, 'show'])->name('ppp.furniture.show');
    Route::get('/{id}/edit', [FurniturePPPController::class, 'edit'])->name('ppp.furniture.edit');
    Route::put('/{id}', [FurniturePPPController::class, 'update'])->name('ppp.furniture.update');
    Route::delete('/{id}', [FurniturePPPController::class, 'destroy'])->name('ppp.furniture.destroy');
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

//maintenance
Route::prefix('/admin/maintenances')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [MaintenanceController::class, 'index'])->name('backend.maintenance.index');
    Route::get('/create', [MaintenanceController::class, 'create'])->name('backend.maintenance.create');
    Route::post('/', [MaintenanceController::class, 'store'])->name('backend.maintenance.store');
    Route::get('/{id}', [MaintenanceController::class, 'show'])->name('backend.maintenance.show');
    Route::get('/{id}/edit', [MaintenanceController::class, 'edit'])->name('backend.maintenance.edit');
    Route::put('/{id}', [MaintenanceController::class, 'update'])->name('backend.maintenance.update');
    Route::delete('/{id}', [MaintenanceController::class, 'destroy'])->name('backend.maintenance.destroy');
    Route::get('/maintenance/items', [MaintenanceController::class, 'getItems'])->name('maintenance.items');
});
//maintenance PPP
Route::prefix('/ppp/maintenances')->middleware(['auth', 'role:ppp'])->group(function () {
    Route::get('/', [MaintenancePPPController::class, 'index'])->name('ppp.maintenance.index');
    Route::get('/create', [MaintenancePPPController::class, 'create'])->name('ppp.maintenance.create');
    Route::post('/', [MaintenancePPPController::class, 'store'])->name('ppp.maintenance.store');
    Route::get('/{id}', [MaintenancePPPController::class, 'show'])->name('ppp.maintenance.show');
    Route::get('/{id}/edit', [MaintenancePPPController::class, 'edit'])->name('ppp.maintenance.edit');
    Route::put('/{id}', [MaintenancePPPController::class, 'update'])->name('ppp.maintenance.update');
    Route::delete('/{id}', [MaintenancePPPController::class, 'destroy'])->name('ppp.maintenance.destroy');
    Route::get('/maintenance/items', [MaintenancePPPController::class, 'getItems'])->name('maintenance.items');
});


// PPP Section
Route::middleware(['auth', 'role:ppp'])->group(function () {
    // Dashboard and index
    Route::get('/ppp', [PPPController::class, 'index'])->name('ppp.index');
    Route::get('/ppp/dashboard', [PPPController::class, 'index'])->name('ppp.dashboard');


    
    // File Manager
    Route::get('ppp/file-manager', function () {
        return view('ppp.layouts.file-manager');
    })->name('ppp.file-manager');
    
    // File manager routes (laravel-filemanager)
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
    
    // User Management Routes
    Route::resource('users', UsersController::class);
    
    // Profile Routes
    Route::get('/ppp.profile', [PPPController::class, 'profile'])->name('ppp-profile');
    Route::post('ppp/profile/{id}', [PPPController::class, 'profileUpdate'])->name('ppp.profile-update');
     
    // Password Change Routes
    Route::get('ppp.change-password', [PPPController::class, 'changePassword'])->name('ppp.change-password.form');
    Route::post('ppp/change-password/update', [PPPController::class, 'changePasswordStore'])->name('ppp.change-password.store'); 
    // Electronic Routes
    Route::resource('/ppp/electronic', ElectronicPPPController::class); 
    // Furniture Routes
    Route::resource('/ppp/furniture', FurniturePPPController::class); 
    // Room Routes
    //Route::resource('/ppp/room', RoomPPPController::class);
    //maintenance
    Route::resource('/ppp/maintenance', MaintenancePPPController::class);
});

//admin section 
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard and index
    Route::get('/admin', [AdminController::class, 'index'])->name('backend.index');
    //  Route::get('/home', [FrontendController::class, 'home'])->name('home');
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    
    // File Manager
    Route::get('/file-manager', function () {
        return view('backend.layouts.file-manager');
    })->name('file-manager');
    
    // File manager routes (laravel-filemanager)
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
    
    // User Management Routes
    Route::resource('users', UsersController::class);
    
    // Profile Routes
    Route::get('/admin.profile', [AdminController::class, 'profile'])->name('admin-profile');
    Route::post('admin/profile/{id}', [AdminController::class, 'profileUpdate'])->name('admin-profile-update');
     
    // Password Change Routes
    Route::get('admin.change-password', [AdminController::class, 'changePassword'])->name('admin.change-password.form');
    Route::post('change-password/update', [AdminController::class, 'changePasswordStore'])->name('admin.change-password.store');

    // Settings Routes
    Route::get('settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('setting/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');
    
    // Notification Routes
    Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('admin.notification');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('all.notification');
    Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('notification.delete');

    // Booking Routes
    Route::resource('/admin/bookings', BookingController::class);
    
    // Electronic Routes
    Route::resource('/admin/electronic', ElectronicController::class);
    
    // Furniture Routes
    Route::resource('/admin/furniture', FurnitureController::class);
    
    // Room Routes
    Route::resource('/admin/room', RoomController::class);

    //schedule
    Route::resource('/admin/schedule', ScheduleController::class);

    //maintenance
    Route::resource('/admin/maintenance', MaintenanceController::class);
});


// User Section
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [HomeController::class, 'profile'])->name('user-profile');
    Route::post('/profile/{id}', [HomeController::class, 'profileUpdate'])->name('user-profile-update');
    Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
    Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');
    Route::get('/profile', [FrontendController::class, 'profile'])->name('user-profile');
    Route::post('/profile/{id}', [FrontendController::class, 'profileUpdate'])->name('user-profile-update');

    // Change Password Routes
    Route::get('change-password', [FrontendController::class, 'changePassword'])->name('user.change.password.form');
    Route::post('change-password', [FrontendController::class, 'changPasswordStore'])->name('change.password');
});
// Frontend Routes

Route::post('/booking/search', [FrontendController::class, 'search'])->name('booking.search');
