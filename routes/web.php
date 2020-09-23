<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CheckoutBookController;
use App\Http\Controllers\CheckinBookController;
use Illuminate\Support\Facades\Auth;

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

//Route::resource('books', BookController::class);
Route::resources([
    'books' => BookController::class,
    'authors' => AuthorController::class
]);

Route::post('checkout/{book}', [CheckoutBookController::class,'store']);
Route::post('checkin/{book}', [CheckinBookController::class,'store']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
