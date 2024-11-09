<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\BookingController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
//Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//    Lfm::routes();
//});

// CACHE CLEAR ROUTE
Route::get('cache-clear', function () {
    Artisan::call('optimize:clear');
    request()->session()->flash('success', 'Successfully cache cleared.');
    return redirect()->back();
})->name('cache.clear');

Auth::routes(['register' => false]);

    Route::get('user/login', [FrontendController::class, 'login'])->name('login.form');
    Route::post('user/login', [FrontendController::class, 'loginSubmit'])->name('login.submit');
    Route::get('user/logout', [FrontendController::class, 'logout'])->name('user.logout');

    Route::get('user/register', [FrontendController::class, 'register'])->name('register.form');
    Route::post('user/register', [FrontendController::class, 'registerSubmit'])->name('register.submit');
// Reset password
    Route::post('password-reset', [FrontendController::class, 'showResetForm'])->name('password.reset.custom');
// Socialite
    Route::get('login/{provider}/', [LoginController::class, 'redirect'])->name('login.redirect');
    Route::get('login/{provider}/callback/', [LoginController::class, 'Callback'])->name('login.callback');

    Route::get('/', [FrontendController::class, 'home'])->name('home');



//User section 
Route::group(['prefix' => '/user', 'middleware' => ['user']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('user');
    // Profile
    Route::get('/profile', [HomeController::class, 'profile'])->name('user-profile');
    Route::post('/profile/{id}', [HomeController::class, 'profileUpdate'])->name('user-profile-update');
    // Password Change
    Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
    Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');

});



Route::prefix('bookings')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
});

