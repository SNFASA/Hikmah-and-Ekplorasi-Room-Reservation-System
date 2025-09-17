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
use App\Http\Controllers\CatergoryEqupmentController;
use App\Http\Controllers\RoomPPPController;
use App\Http\Controllers\TypeRoomController;
use App\Http\Controllers\MaintenancePPPController;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FacultyOfficeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\FacilitiesReservationController;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Broadcast;

// Authentication Routes
Auth::routes(['register' => true]);


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
    session()->flash('success', 'Successfully cache cleared.');
    return redirect()->back();
})->name('cache.clear');

// Storage Link
Route::get('storage-link', [AdminController::class, 'storageLink'])->name('storage.link');

// Home Route (Require Login)
Route::get('/', [HomeController::class, 'index'])->name('user')->middleware('auth');
Route::get('/home', [FrontendController::class, 'home'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/booking-form', [HomeController::class, 'bookingForm'])->name('booking.form');

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

//department
Route::prefix('/depatment')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DepartmentController::class, 'index'])->name('backend.department.index');
    Route::get('/create', [DepartmentController::class, 'create'])->name('backend.department.create');
    Route::post('/', [DepartmentController::class, 'store'])->name('backend.department.store');
    Route::get('/{id}', [DepartmentController::class, 'show'])->name('backend.department.show');
    Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('backend.department.edit');
    Route::put('/{id}', [DepartmentController::class, 'update'])->name('backend.department.update');
    Route::delete('/{id}', [DepartmentController::class, 'destroy'])->name('backend.department.destroy');
});

//faculty_office
Route::prefix('/facultyOffice')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [FacultyOfficeController::class, 'index'])->name('backend.facultyOffice.index');
    Route::get('/create', [FacultyOfficeController::class, 'create'])->name('backend.facultyOffice.create');
    Route::post('/', [FacultyOfficeController::class, 'store'])->name('backend.facultyOffice.store');
    Route::get('/{id}', [FacultyOfficeController::class, 'show'])->name('backend.facultyOffice.show');
    Route::get('/{id}/edit', [FacultyOfficeController::class, 'edit'])->name('backend.facultyOffice.edit');
    Route::put('/{id}', [FacultyOfficeController::class, 'update'])->name('backend.facultyOffice.update');
    Route::delete('/{id}', [FacultyOfficeController::class, 'destroy'])->name('backend.facultyOffice.destroy');
});

//cpurses
Route::prefix('/courses')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('backend.course.index');
    Route::get('/create', [CourseController::class, 'create'])->name('backend.course.create');
    Route::post('/', [CourseController::class, 'store'])->name('backend.course.store');
    Route::get('/{id}', [CourseController::class, 'show'])->name('backend.course.show');
    Route::get('/{id}/edit', [CourseController::class, 'edit'])->name('backend.course.edit');
    Route::put('/{id}', [CourseController::class, 'update'])->name('backend.course.update');
    Route::delete('/{id}', [CourseController::class, 'destroy'])->name('backend.course.destroy');
});

//schedule
Route::prefix('/admin/schedules')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [ScheduleController::class, 'index'])->name('backend.schedule.index');
    Route::get('/create', [ScheduleController::class, 'create'])->name('backend.schedule.create');
    Route::post('/', [ScheduleController::class, 'store'])->name('backend.schedule.store');
    Route::get('/{id}', [ScheduleController::class, 'show'])->name('backend.schedule.show');
    Route::get('/{id}/edit', [ScheduleController::class, 'edit'])->name('backend.schedule.edit');
    Route::put('/{id}', [ScheduleController::class, 'update'])->name('backend.schedule.update');
    Route::delete('/backend/schedule/{id}', [ScheduleController::class, 'destroy'])->name('backend.schedule.destroy');
    Route::post('/backend/schedule/bulk-delete', [ScheduleController::class, 'bulkDestroy'])->name('backend.schedule.bulk-destroy');
    Route::delete('/backend/schedule/batch/{batchId}', [ScheduleController::class, 'destroyByBatch'])->name('backend.schedule.destroy-batch');

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

//reservation facilites
Route::prefix('/admin/reservation')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [FacilitiesReservationController::class, 'index'])->name('backend.reservation.index');
    Route::get('/create', [FacilitiesReservationController::class, 'create'])->name('backend.reservation.create');
    Route::post('/', [FacilitiesReservationController::class, 'store'])->name('backend.reservation.store');
    Route::get('/{id}', [FacilitiesReservationController::class, 'show'])->name('backend.reservation.show');
    Route::get('/{id}/edit', [FacilitiesReservationController::class, 'edit'])->name('backend.reservation.edit');
    Route::put('/{id}', [FacilitiesReservationController::class, 'update'])->name('backend.reservation.update');
    Route::delete('/{id}', [FacilitiesReservationController::class, 'destroy'])->name('backend.reservation.destroy');
    Route::get('/reservation', [FacilitiesReservationController::class, 'roomChart'])->name('backend.reservationChart');
    Route::get('reservation/chart', [FacilitiesReservationController::class, 'getreservationsByMonth'])->name('bookings.reservationsByMonth');
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
// category equipment
Route::prefix('/admin/categories')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [CatergoryEqupmentController::class, 'index'])->name('backend.category.index');
    Route::get('/create', [CatergoryEqupmentController::class, 'create'])->name('backend.category.create');
    Route::post('/', [CatergoryEqupmentController::class, 'store'])->name('backend.category.store');
    Route::get('/{id}', [CatergoryEqupmentController::class, 'show'])->name('backend.category.show');
    Route::get('/{id}/edit', [CatergoryEqupmentController::class, 'edit'])->name('backend.category.edit');
    Route::put('/{id}', [CatergoryEqupmentController::class, 'update'])->name('backend.category.update');
    Route::delete('/{id}', [CatergoryEqupmentController::class, 'destroy'])->name('backend.category.destroy');
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
// type room
Route::prefix('/admin/typeroom')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [TypeRoomController::class, 'index'])->name('backend.type_room.index');
    Route::get('/create', [TypeRoomController::class, 'create'])->name('backend.type_room.create');
    Route::post('/', [TypeRoomController::class, 'store'])->name('backend.type_room.store');
    Route::get('/{id}', [TypeRoomController::class, 'show'])->name('backend.type_room.show');
    Route::get('/{id}/edit', [TypeRoomController::class, 'edit'])->name('backend.type_room.edit');
    Route::put('/{id}', [TypeRoomController::class, 'update'])->name('backend.type_room.update');
    Route::delete('/{id}', [TypeRoomController::class, 'destroy'])->name('backend.type_room.destroy');
});
//room PPP
Route::prefix('/ppp/rooms')->middleware(['auth', 'role:ppp'])->group(function () {
    Route::get('/', [RoomPPPController::class, 'index'])->name('ppp.room.index');
   // Route::get('/create', [RoomPPPController::class, 'create'])->name('ppp.room.create');
   // Route::post('/', [RoomPPPController::class, 'store'])->name('ppp.room.store');
    Route::get('/{id}', [RoomPPPController::class, 'show'])->name('ppp.room.show');
    Route::get('/{id}/edit', [RoomPPPController::class, 'edit'])->name('ppp.room.edit');
    Route::put('/{id}', [RoomPPPController::class, 'update'])->name('ppp.room.update');
    Route::delete('/{id}', [RoomPPPController::class, 'destroy'])->name('ppp.room.destroy');
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
    //Route::get('/maintenance/items', [MaintenanceController::class, 'getItems'])->name('maintenance.items');
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
    //Route::post('/maintenance/get-items', [MaintenanceController::class, 'getItems'])->name('maintenance.getItems');
});
Route::get('/ajax/maintenance/items', [MaintenanceController::class, 'getItems'])->middleware('auth')->name('maintenance.items');


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
    Route::resource('/ppp/room', RoomPPPController::class);
    //maintenance
    Route::resource('/ppp/maintenance', MaintenancePPPController::class);
});

//admin section
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard and index
    Route::get('/admin', [AdminController::class, 'index'])->name('backend.index');
    //  Route::get('/home', [FrontendController::class, 'home'])->name('home');
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    // API route for activities (if you need dynamic loading)
    Route::get('/api/activities', [AdminController::class, 'getRecentActivities'])->name('api.activities');
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

    //department
    Route::resource('department', DepartmentController::class);

    //Faculty_office routers
    //Route::resource('facultyOffice', FacultyOfficeController::class);
    
    //course
    Route::resource('course', CourseController::class);
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
    Route::middleware(['auth'])->group(function () {
        // Main notifications index
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notification.index');
        
        // Get notification count for AJAX
        Route::get('/notifications/count', [NotificationController::class, 'getCount'])->name('notification.count');
        
        // Show notification (redirect to actionURL and mark as read)
        Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notification.show');
        
        // View full detail of a single notification
        Route::get('/notifications/{id}/detail', [NotificationController::class, 'detail'])->name('notification.detail');
        
        // Mark a specific notification as read
        Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markRead'])->name('notification.mark-read');
        
        // Mark all notifications as read
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notification.mark-all-read');
        
        // Soft-delete (hide) a specific notification
        Route::delete('/notifications/{id}', [NotificationController::class, 'delete'])->name('notification.delete');
        
        // Clear all notifications (set is_deleted = true)
        Route::post('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notification.clear-all');
    });

    // Add Pusher broadcasting routes
    Broadcast::routes(['middleware' => ['auth']]);


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
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user', [HomeController::class, 'index'])->name('user');
    Route::get('user/',[HomeController::class, 'index'])->name('user.index');
    // Change Password Routes (Using HomeController)
    Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
    Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');
    // Profile Routes
    Route::get('/profile', [FrontendController::class, 'profile'])->name('user-profile');
    Route::post('/profile/{id}', [FrontendController::class, 'profileUpdate'])->name('user-profile-update');
});



// Booking form and filters home pagr
Route::get('/booking-filter', [BookingController::class, 'showFilterForm'])->name('booking.filter.form');
Route::post('/filter-available-rooms', [BookingController::class, 'filterAvailableRooms'])->name('filter.available.rooms')->middleware('auth');


// Booking routes (standard form)
Route::get('/room.reserve/{id}', [BookingController::class, 'showBookingForm'])->name('room.reserve');
Route::post('/room.reserve/{id}', [BookingController::class, 'storeBookingForm'])->name('bookingformStore');

// Reservation routes (reservation form)
Route::post('/room.reservation/{id}', [FacilitiesReservationController::class, 'reservationformStore'])->name('reservationformStore');
// cancel reservation
Route::delete('/cancel-reservation/{id}', [FacilitiesReservationController::class, 'cancelreserved'])->name('cancel.reservation');
//edit
Route::get('reservation/{id}/edit', [FacilitiesReservationController::class, 'Formedit'])->name('reservation.edit');
Route::put('reservation/{id}', [FacilitiesReservationController::class, 'Formupdate'])->name('reservation.update');


// calander booking home page
Route::get('/calendar', [BookingController::class, 'calendar'])->name('show.calendar');
Route::get('/calendarAdmin', [BookingController::class, 'calendarAdmin'])->name('show.calendar.admin');
//My Booking
Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my.bookings');
// cancel booking
Route::delete('/cancel-booking/{id}', [BookingController::class, 'cancelBooking'])->name('cancel.booking');
//edit
Route::get('booking/{id}/edit', [BookingController::class, 'Formedit'])->name('booking.edit');
Route::put('booking/{id}', [BookingController::class, 'Formupdate'])->name('booking.update');

// email ( not uses)
Route::get('/emails/send/{booking}', [EmailController::class, 'sendBookingEmail'])->name('emails.send');
Route::get('/emails/send-reservation/{reservation}', [EmailController::class, 'sendReservationEmail'])->name('emails.reservation');
//Feedback Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('backend.feedback.index');
    Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('frontend.pages.feedbackcreate');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/{feedback}/edit', [FeedbackController::class, 'edit'])->name('frontend.pages.feedbackedit');
    Route::put('/feedback/{feedback}', [FeedbackController::class, 'update'])->name('feedback.update');
    Route::delete('/feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
    Route::get('/feedback/show', [FeedbackController::class, 'statistic'])->name('backend.feedback.statistic');
    Route::get('/feedback/{feedback}/show', [FeedbackController::class, 'show'])->name('frontend.pages.feedbackshow');
});
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    Mail::raw('Test email content. ini adalah cubaan test email', function ($message) {
        $message->to('your@email.com')
                ->subject('Testing SMTP Mailtrap');
    });
    return 'Email sent.';
});
