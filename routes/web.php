<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\HouseholdgoodsController;
use App\Http\Controllers\CraftController;
use App\Http\Controllers\ToiletriesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\VoteController;

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

Route::resource('products', '\App\Http\Controllers\AdminController')->middleware(['auth.admin.panel']);
Route::delete('/deleteImage/{product}/{image}', [AdminController::class, 'deleteImage'])->name('delete')->middleware(['auth.admin.panel']);
Route::resource('coupons', '\App\Http\Controllers\CouponController')->middleware(['auth.admin.panel']);
Route::resource('checkouts', '\App\Http\Controllers\CheckoutController');

Route::get('/', [PageController::class, 'mainpage']);
Route::get('/search', [PageController::class, 'search']);
Route::get('/category/{category}', [PageController::class, 'index']);
Route::get('/{id}', [PageController::class, 'show'])->whereNumber('id');


Route::get('/pages/form', array('as' => 'form', function () {
    return view('pages.page.form');
}));

Route::get('/pages/checkout', array('as' => 'checkout', function () {
    return view('pages.page.checkout');
}));

Route::get('/admin',  function () {
    return view('layout.adminpage');
})->middleware(['auth.admin.panel']);

Route::view('/login', 'auth.login');

Route::resource('checkouts', CheckoutController::class);

Route::get('/dashboard', function () {
    return view('pages.page.message')->with('message',"Succesfully logged in!");
})->middleware(['auth'])->name('dashboard');

Route::get('/cart', [CartController::class, 'show'])->name('display-cart');
Route::post('/add-to-cart', [CartController::class, 'add'])->name('add-to-cart');
Route::post('cart', [CartController::class, 'update'])->name('update-cart');
Route::post('cart/delete', [CartController::class, 'delete'])->name('delete-product-from-cart');

require __DIR__.'/auth.php';

Route::resource('polls', PollController::class);
Route::get('/polls/{id}/answer', [OptionController::class, 'view_answers'])->whereNumber('id');
Route::post('/polls/{id}/answer/submit', [OptionController::class, 'add_answer'])->whereNumber('id');
Route::post('polls/{id}/vote', [VoteController::class, 'vote'])->whereNumber('id');