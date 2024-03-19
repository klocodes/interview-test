<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Inertia::setRootView('app');

Route::get('sign-in', [AuthController::class, 'signIn'])->name('auth.sign_in')->middleware('guest');
Route::post('login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [PagesController::class, 'home'])->name('home');

    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});
