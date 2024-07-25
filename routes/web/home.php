
<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;


Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', [HomeController::class , 'index']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
 
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/product-detail/{id}', [HomeController::class , 'productDetail'])->name('product-detail');
Route::post('/add-cart/{id}', [HomeController::class , 'addToCart'])->name('add-cart');
Route::get('/',[HomeController::class,'homeProducts'])->name('products-index');
Route::get('/show-carts',[HomeController::class,'showCarts'])->name('show-carts');
Route::delete('/delete-carts/{id}',[HomeController::class,'deleteCarts'])->name('delete-carts');
Route::get('/cash-order',[HomeController::class,'cashOrder'])->name('cash-order');
Route::get('/stripe/{totalPrice}',[HomeController::class,'stripe'])->name('stripe');
Route::post('stripe/{totalPrice}', [HomeController::class,'stripePost'])->name('stripe.post');

require __DIR__.'/../auth.php';
