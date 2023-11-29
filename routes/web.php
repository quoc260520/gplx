<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\DrivingLicenseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and ALL of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('post.login');

Route::get('/register', function () {
    return view('register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('post.register');

Route::group(['middleware' => ['checkLogin']], function () {
    Route::middleware('role:admin|staff|client')
        ->get('/', [AuthController::class, 'dashboard'])
        ->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::prefix('staff')
        ->middleware('role:admin|staff')
        ->group(function () {
            Route::get('/', [UserController::class, 'staff'])->name('staff.list');
            Route::get('/create', [UserController::class, 'getStaffCreate'])->name('staff.create');
            Route::post('/create', [UserController::class, 'staffCreate'])->name('post.staff.create');
            Route::get('/update/{id}', [UserController::class, 'getStaffUpdate'])->name('staff.update');
            Route::post('/update/{id}', [UserController::class, 'staffUpdate'])->name('post.staff.update');
            Route::delete('/delete/{id}', [UserController::class, 'staffDelete'])->name('staff.delete');
        });
    Route::prefix('client')
        ->middleware('role:admin|staff')
        ->group(function () {
            Route::get('/', [UserController::class, 'client'])->name('client.list');
            Route::get('/create', [UserController::class, 'getClientCreate'])->name('client.create');
            Route::post('/create', [UserController::class, 'clientCreate'])->name('post.client.create');
            Route::get('/update/{id}', [UserController::class, 'getClientUpdate'])->name('client.update');
            Route::post('/update/{id}', [UserController::class, 'clientUpdate'])->name('post.client.update');
            Route::delete('/delete/{id}', [UserController::class, 'clientDelete'])->name('client.delete');
        });
    Route::prefix('gplx')
        ->middleware('role:admin|staff|client')
        ->group(function () {
            Route::get('/', [DrivingLicenseController::class, 'index'])->name('gplx.list');
            Route::get('show/{id}', [DrivingLicenseController::class, 'showModal'])->name('gplx.show');
            Route::get('/create', [DrivingLicenseController::class, 'create'])->name('gplx.create');
            Route::post('/create', [DrivingLicenseController::class, 'store'])->name('post.gplx.create');
            Route::get('/update/{id}', [DrivingLicenseController::class, 'show'])->name('gplx.update');
            Route::post('/update/{id}', [DrivingLicenseController::class, 'update'])->name('post.gplx.update');
            Route::get('/extend', [DrivingLicenseController::class, 'extend'])->name('gplx.extend');
            Route::post('/extend/{id}', [DrivingLicenseController::class, 'postExtend'])->name('post.gplx.extend');
            Route::delete('/delete/{id}', [DrivingLicenseController::class, 'destroy'])->name('gplx.delete');
        });
    Route::prefix('supplier')
        ->middleware('role:admin|staff')
        ->group(function () {
            Route::get('/', [SupplierController::class, 'getViewSupplier'])->name('get.supplier');
            Route::get('/create', [SupplierController::class, 'getViewCreateSupplier'])->name('post.supplier.view');
            Route::post('/create', [SupplierController::class, 'createSupplier'])->name('post.supplier.action');
            Route::get('/update/{id}', [SupplierController::class, 'getViewUpdate'])->name('update.supplier.view');
            Route::post('/update/{id}', [SupplierController::class, 'updateSupplier'])->name('update.supplier.action');
            Route::delete('/delete/{id}', [SupplierController::class, 'deleteSupplier'])->name('delete.supplier');
        });
});

Route::get('/forgot-password', function () {
    return view('forgot-password');
})->name('forgot-password');
Route::post('/forgot-password', [MailController::class, 'forgotPassWord'])->name('post.forgot');
Route::get('/reset-password', [AuthController::class, 'getViewReset'])->name('get.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('post.reset');

