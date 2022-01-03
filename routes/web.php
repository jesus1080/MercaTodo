<?php

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('users', UserController::class)->middleware(['auth', 'verified']);

#Route::middleware(['auth', 'verified'])->get('/users', [UserController::class, 'index'])->name('users');
#Route::middleware(['auth', 'verified'])->get('/users/{id}', [UserController::class, 'edit'])->name('');
#Route::get('/users/edit/{id}', [UserController::class, 'edit'])
                #->middleware('auth')
                #->name('users.edit');

#Route::resource('users', UserController::class)->name('users.index');
#Route::get('/users', [UserController::class, 'index'])->name('users.index');
require __DIR__.'/auth.php';


