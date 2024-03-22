<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OperationsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UsersController;
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

Route::get('sign-in', [PagesController::class, 'signIn'])->name('pages.sign_in')->middleware('guest');

Route::post('login', [AuthController::class, 'login'])->name('auth.login')->middleware('guest');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [PagesController::class, 'home'])->name('home');
    Route::get('operations', [PagesController::class, 'operations'])->name('operations');

    Route::get('user', [UsersController::class, 'getAuthUser'])->name('users.get_auth_user');
    Route::get('balance', [UsersController::class, 'balance'])->name('users.balance');

    Route::get('operations/latest', [OperationsController::class, 'latest'])->name('operations.latest');
    Route::get('operations/history', [OperationsController::class, 'history'])->name('operations.history');

    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});
