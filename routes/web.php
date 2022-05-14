<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Report\ReportController;
use App\Models\Invoice;
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

Route::get('/products-client', [ClientController::class, 'index'])->name('productsClient.index')->middleware((['auth','verified','role:client|admin']));
Route::get('/products-show/{id}', [ClientController::class, 'show'])->name('productsClient.show')->middleware((['auth','verified','role:client|admin']));


Route::group(['middleware' => ['role:admin']], function () {
    Route::resource('users', UserController::class)->middleware(['auth', 'verified']);
    Route::resource('products', ProductController::class, [
        'except' => ['show']])->middleware(['auth', 'verified']);
    //import-export-report

    Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('products/export', [ProductController::class, 'export'])->name('products.export');
    Route::get('products/report', [ReportController::class, 'index'])->name('products.report');
    Route::get('/products/generate',[ReportController::class,'generate'])->name('generate');
    
});

Route::group(['middleware' => ['role:admin|client']], function () {
    //cart
    Route::post('/cart', [CartController::class, 'store'])
        ->name('cart.store')->middleware((['auth','verified']));
    Route::get('/cart-content', [CartController::class, 'index'])
        ->name('cart-content.index')->middleware((['auth','verified']));
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart-content-desroy', [CartController::class, 'destroycart'])
        ->name('cart.destroy.content');
    Route::put('/cart-update/{id}', [CartController::class, 'update'])
        ->name('cart.update');

    //invoices
    Route::post('webcheckout', [InvoiceController::class, 'store'])->name('webcheckout.store');
    Route::get('/invoices', [InvoiceController::class, 'indexInvoices'])->name('webcheckout.invoices');
    Route::get('/invoice-show{id}',[InvoiceController::class, 'show'])->name('webchekout.show');
});


Route::get('/pdf',function (){
    $invoices = Invoice::all();
    return view('reports.invoice',compact('invoices'));
});



require __DIR__.'/auth.php';