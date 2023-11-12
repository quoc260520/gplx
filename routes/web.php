<?php

use App\Http\Controllers\AuthController;
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
    // Route::prefix('answers')
    //     ->middleware('role:admin')
    //     ->group(function () {
    //         Route::get('list', [QuestionController::class, 'index'])->name('answer.list');
    //         Route::get('create', [QuestionController::class, 'create'])->name('answer.create');
    //         Route::post('create', [QuestionController::class, 'postCreate'])->name('answer.post.create');
    //     });
});
