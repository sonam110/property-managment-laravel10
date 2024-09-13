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
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\UnitTypeController;
use App\Http\Controllers\TenantSettingController;
use App\Http\Controllers\ExtraChargeController;
use App\Http\Controllers\LateFeeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExpenseController;
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


Route::get('/optimize', function () {
    \Artisan::call('optimize:clear');
    \Artisan::call('cache:forget spatie.permission.cache');
    return redirect('/');
});

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

Route::get('/unit-map', function () {
    return view('units-map');
});

 Route::post('get-state', [UserController::class, 'getState'])->name('api.get-state');
 Route::post('get-units', [LeaseController::class, 'getUnits'])->name('api.get-units');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
   
    Route::middleware(['auth'])->group(function () {

        /* --------------User Management --------------------*/
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('users', UserController::class);
        Route::post('user-list', [UserController::class, 'userList'])->name('api.user-list');
        Route::get('user-delete/{id}', [UserController::class, 'destroy'])->name('user-delete');
        Route::resource('tenants', TenantController::class);
        Route::post('tenants-list', [TenantController::class, 'tenantList'])->name('api.tenant-list');
        Route::get('tenants-destroy/{id}', [TenantController::class, 'destroy'])->name('tenants-destroy');


        /* --------------Property --------------------*/
        Route::resource('property', PropertyController::class);
        Route::post('property-list', [PropertyController::class, 'propertyList'])->name('api.property-list');
        Route::get('property-destroy/{id}', [PropertyController::class, 'destroy'])->name('property-destroy');

        Route::get('property-copy/{id}', [PropertyController::class, 'copy'])->name('property-copy');
        Route::get('property-units/{id}', [PropertyController::class, 'propertyUnits'])->name('property-units');
        Route::get('unitsall', [PropertyController::class, 'unitsall'])->name('unitsall');
        

        /* --------------leases --------------------*/
        Route::resource('leases', LeaseController::class);
        Route::get('tenant-leases/{id?}', [LeaseController::class, 'index'])->name('tenant-leases');
        Route::post('leases-list', [LeaseController::class, 'leaseList'])->name('api.leases-list');
        Route::get('leases-destroy/{id}', [LeaseController::class, 'destroy'])->name('leases-destroy');

        Route::get('leases-copy/{id}', [LeaseController::class, 'copy'])->name('leases-copy');
        Route::get('contract-document', [LeaseController::class, 'contractDocument'])->name('contract-document');

        Route::get('generate-pdf/{id}', [LeaseController::class, 'generatePDF'])->name('generate-pdf');
       
        Route::get('lease-show', function () {
            return view('lease.lease-pdf');
        })->name('lease-show');

        Route::post('lease-fetch', [LeaseController::class, 'fetchLeaseData'])->name('leases.fetch');
        Route::post('leases-preview/{id}', [LeaseController::class, 'previewPdf'])->name('leases.preview');

         Route::get('invoice', [InvoiceController::class, 'invoice'])->name('invoice');
         Route::post('invoice-list', [InvoiceController::class, 'invoiceList'])->name('invoice-list');
         Route::get('invoice-view/{id}', [InvoiceController::class, 'invoiceView'])->name('invoice-view');
         Route::get('cam-invoice/{id}', [InvoiceController::class, 'camInvoice'])->name('cam-invoice');
         Route::get('utility-invoice/{id}', [InvoiceController::class, 'utilityInvoice'])->name('utility-invoice');
         Route::get('invoice-edit/{id}', [InvoiceController::class, 'invoiceEdit'])->name('invoice-edit');

          Route::get('invoice-template', [InvoiceController::class, 'invoiceTemplate'])->name('invoice-template');
          Route::post('invoice-update', [InvoiceController::class, 'invoiceUpdate'])->name('invoice-update');


          Route::post('download-pdf', [InvoiceController::class, 'downloadPdf'])->name('pdf.download');


          /* Payment------------------*/
           Route::post('add-payment', [PaymentController::class, 'addPayment'])->name(' add-payment');
           Route::get('payment-history', [PaymentController::class, 'index'])->name('payment-history');
            Route::post('payment-history-list', [PaymentController::class, 'paymentHistoryList'])->name('payment-history-list');
            Route::get('edit-payment/{id}', [PaymentController::class, 'edit'])->name('edit-payment');
            Route::post('payment-update/{id}', [PaymentController::class, 'update'])->name('payment-update');

              Route::get('payment-delete/{id}', [PaymentController::class, 'destroy'])->name('payment-delete');
              Route::get('download-recipt/{id}', [PaymentController::class, 'download'])->name('download-recipt');

            /*--------Expenses -------------------*/
            Route::resource('expense', ExpenseController::class);
          
            Route::post('expense-list', [ExpenseController::class, 'expenseList'])->name('api.expense-list');
            Route::get('expense-destroy/{id}', [ExpenseController::class, 'destroy'])->name('expense-destroy');


        /* --------------settings --------------------*/
        Route::resource('app-setting', AppsettingController::class);
        Route::resource('utility', UtilityController::class);
        Route::resource('unit-type', UnitTypeController::class);
        Route::resource('property-type', PropertySettingController::class);
    
        Route::resource('extra-charge', ExtraChargeController::class);
        Route::resource('lease-type', LeaseSettingController::class);
        Route::resource('late-fees', LateFeeController::class);
        Route::put('leaseupdate/{id}', [LeaseSettingController::class, 'leaseupdate'])->name('leaseupdate');
        Route::get('lease-setting', [LeaseSettingController::class, 'index'])->name('lease-setting');

        Route::get('tenant-setting', [TenantSettingController::class, 'index'])->name('tenant-setting');
        Route::resource('tenant-type', TenantSettingController::class);
        Route::resource('user-profile', ProfileController::class);
        Route::get('change-password', [ProfileController::class, 'index'])->name('change-password');
        Route::post('change-password-update', [ProfileController::class, 'changePasswordUpdate'])->name('change-password-update');
        Route::put('tenantupdate/{id}', [TenantSettingController::class, 'tenantupdate'])->name('tenantupdate');



       
        
            
        
    });
        
  

});

