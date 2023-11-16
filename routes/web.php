<?php

use App\Http\Controllers\AuthController;
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
});
