<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\AppsettingController;
use App\Http\Controllers\PropertySettingController;
use App\Http\Controllers\LeaseSettingController;
use App\Http\Controllers\TenantSettingController;
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

require __DIR__ . '/auth.php';

Route::get('/', function () {
   return view('admin.login');
});

Route::get('login/', function () {
    if (\Auth::check()) {
        return redirect('/dashboard');
    }
    return view('admin.login');
})->name('login');

Route::get('/register', function () {
    return view('admin.register');
});

 Route::post('get-state', [UserController::class, 'getState'])->name('api.get-state');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/edit-profile', 'AdminController@editprofile')->name('edit-profile');
    Route::post('/change-password', 'AdminController@changePassword')->name('change-password');
    Route::post('/update-profile', 'AdminController@updateProfile')->name('update-profile');
    Route::get('need-help', 'NoMiddlewareController@needhelp')->name('need-help');
   
    Route::get('/logout', 'AdminController@logout')->name('logout');
   
    Route::middleware(['auth'])->group(function () {

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('users', UserController::class);
        Route::post('user-list', [UserController::class, 'userList'])->name('api.user-list');
        Route::get('user-delete/{id}', [UserController::class, 'destroy'])->name('user-delete');
        Route::resource('tenants', TenantController::class);
        Route::post('tenants-list', [TenantController::class, 'tenantList'])->name('api.tenant-list');

        Route::resource('app-setting', AppsettingController::class);
        Route::resource('utility', PropertySettingController::class);
        Route::resource('unit-type', PropertySettingController::class);
        Route::resource('property-type', PropertySettingController::class);
        Route::resource('late-fees', LeaseSettingController::class);
        Route::resource('extra-charge', LeaseSettingController::class);
        Route::resource('lease-type', LeaseSettingController::class);
        Route::resource('tenant-type', TenantSettingController::class);
            
        
    });
        
  

});

