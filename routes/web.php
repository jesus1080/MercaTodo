<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
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

// Route::get('/dashboard', function () {
//     //$products = Product::paginate(5);
//     $products = Product::where("status","=",true)->paginate(5);
//     return Inertia::render('Dashboard',compact('products'));
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products2', [ProductController::class, 'show'])->name('products.show')->middleware((['auth','verified']));


Route::group(['middleware' => ['role:admin']], function () {
    Route::resource('users', UserController::class)->middleware(['auth', 'verified']);
    Route::resource('products', ProductController::class,[
        'except' => ['show']])->middleware(['auth', 'verified']);
});
require __DIR__.'/auth.php';






