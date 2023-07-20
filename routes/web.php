<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KindQuestionController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

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
})->name('home');

Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [AuthController::class, 'login'])->name('post.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware('role:admin')
    ->get('dashboard', [AuthController::class, 'dashboard'])
    ->name('dashboard');
Route::prefix('answers')
    ->middleware('role:admin')
    ->group(function () {
        Route::get('list', [QuestionController::class, 'index'])->name('answer.list');
        Route::get('create', [QuestionController::class, 'create'])->name('answer.create');
        Route::post('create', [QuestionController::class, 'postCreate'])->name('answer.post.create');
    });

Route::prefix('kind')
    ->middleware('role:admin')
    ->group(function () {
        Route::get('kind', [KindQuestionController::class, 'index'])->name('kind.list');
        Route::post('create', [KindQuestionController::class, 'create'])->name('kind.create');
    });
