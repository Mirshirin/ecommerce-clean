
<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Route::view('dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', [HomeController::class , 'index']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::put('/profile', [ProfileController::class, 'updateinformation'])->name('profile.updateinformation');

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

Route::get('/send-mail', [EmailController::class , 'sendContactEmail'])->name('sendContactEmail');

Route::get('/product-detail/{id}', [HomeController::class , 'productDetail'])->name('product-detail');
Route::get('/',[HomeController::class,'homeProducts'])->name('products-index');

Route::get('/show-carts',[CartController::class,'showCarts'])->name('show-carts');
Route::post('/add-cart/{id}', [CartController::class , 'addToCart'])->name('add-cart');
Route::delete('/delete-carts/{id}',[CartController::class,'deleteCarts'])->name('delete-carts');

// Route::post('/payment',[PaymentController::class,'payment'])->name('payment')->middleware('auth');
Route::get('/checkout',[PaymentController::class,'checkout'])->name('checkout')->middleware('auth');
Route::get('/thanks/{orderId}',[PaymentController::class,'thankyou'])->name('thankyou');
Route::post('/processCheckout',[PaymentController::class,'processCheckout'])->name('processCheckout');
// Route::match(['get','post'],'/pay-result',[PaymentController::class,'payResult'])->name('pay-result');

Route::get('/check-cart-status', function () {
    $isCartEmpty = session()->get('cart') === null || empty(session()->get('cart'));
    return response()->json(['isCartEmpty' => $isCartEmpty]);
});
//Route::match(['get','post'],'/payments',[HomeController::class,'payments'])->name('payments');
require __DIR__.'/../auth.php';
